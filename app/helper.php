<?php 
// Upload File
if (!function_exists('uploadFile')) {
	function uploadFile($dir, $file)
	{
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
        //uniqid : Tạo id duy nhât
		$fileName = uniqid() . '_' . $file->getClientOriginalName();
		$fileName = str_replace(' ', '', $fileName);
		$file->move($dir, $fileName);

		return $fileName;
	}
}

if (!function_exists('uploadFileIndex')) {
	function uploadFileIndex($dir, $file, $arrIndex)
	{
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
        //uniqid : Tạo id duy nhât
		$fileName = $file->getClientOriginalName();
		$arr2 = explode('-', $fileName);
		foreach ($arrIndex as $key => $value) {
			$arr = explode('-', $value);
			$flagCompare = true;
			for ($i=0; $i <  count($arr2); $i++) {
				if ($arr[$i] != $arr2[$i]) {
					$flagCompare = false;
				}
			}
			if ($flagCompare) {
				if (count($arr) < 3) {
					$index = 0;
					$size = $arr[1];
				} else if(count($arr) == 3) {
					$index = $arr[1];
					$size = $arr[2];
				} else {
					$index = $arr[count($arr) - 2];
					$size = $arr[count($arr) - 1];
				}
				unset($arrIndex[$key]);
				break;
			}
			
		}
		$fileName = uniqid() . '_' . 'smallVideo.mp4';
		$fileName = str_replace(' ', '', $fileName);
		$file->move($dir, $fileName);

		if (isset($index) && isset($size)) {
			return ['fileName' => $fileName, 'index' => $index, 'size' => $size, 'update' => false];
		} else {
			return false;
		}
	}
}

function download($dir, $fileName, $url)
{
	try 
	{
		$contents = file_get_contents(
			$url
		);

		file_put_contents(
			$dir .  $fileName,
			$contents
		);
		return true;
	}
	catch(Exception $exception)
	{
		return ['error' => true, 'status' => 404];
	}
}

// make Video
function combineVideo($arrVideo, $path, $outputfile) {
	try 
	{
		$listVideo = '';
		for ($i=0; $i < count($arrVideo) ; $i++) {
			$output = '30k-' . $arrVideo[$i]['fileName'];
			$command = 'cd '. $path .' && ffmpeg -i '. $arrVideo[$i]['fileName'] . ' -c copy -video_track_timescale 30k ' . $output;
			$listVideo .= "file '" . $output . "'\n";
			exec($command);
		}
		Illuminate\Support\Facades\File::put($path . 'listVideoTxt.txt', $listVideo);
		$command = 'cd '. $path .' && ffmpeg -f concat -i listVideoTxt.txt -vf select=concatdec_select -y temp.mp4';
		exec($command);
		$command = 'cd '. $path .' && ffmpeg -i temp.mp4 -c copy -an -y ' . $outputfile;
		exec($command);
		unlink($path . 'temp.mp4');
		unlink($path . 'listVideoTxt.txt');
		for ($i=0; $i < count($arrVideo) ; $i++) {
			unlink($path  . '30k-' . $arrVideo[$i]['fileName']);
		}

		return true;
	}
	catch(Exception $exception)
	{
		return $exception->getMessage();
	} 
}

function makeAudioGG($data, $path, $outputfile) {
	try
	{
		$command = 'cd '. $path .' && gtts-cli "' . removeSpecChra($data['audio']) . '" --lang vi --output temp.mp3';
		exec($command);
		$command = 'cd '. $path .' && ffmpeg -i temp.mp3 -filter:a "atempo= ' . (float)$data['speed'] . '" -vn -y ' . $outputfile;
		exec($command);
		unlink($path . 'temp.mp3');
		
		return true;
	}
	catch(Exception $exception)
	{
		return $exception->getMessage();
	} 
}

function makeAudioZalo($data) {
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_HTTPHEADER => array(
			"apikey: fyVohWXJYa89haBoZUfQqRrsDQmKdBVC",
		),
		CURLOPT_POSTFIELDS => 
		http_build_query([
			"input" => $data['audio'],
			"speed" => $data['speed'],
			"encode_type" => "mp3",
			"speaker_id" => $data['speech']
		]),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_URL => 'https://api.zalo.ai/v1/tts/synthesize',
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POST => 1,
		CURLOPT_SSL_VERIFYPEER => false,
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
		return $err;
	} else {
		return $response;
	}
}

function makeAudioFPT($data) {
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.fpt.ai/hmi/tts/v5',
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => $data['audio'],
		CURLOPT_HTTPHEADER => array(
			'api-key: DqDJVqc8XHwNvanfe5XGqAEWkG7rWEqp',
			'speed: ' . $data['speed'],
			'voice: ' . $data['speech']
		),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 30
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
		return $err;
	} else {
		return $response;
	}
}

function downloadAudio($path, $outputfile, $url)
{
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_NOBODY, 0);
	curl_setopt($curl, CURLOPT_TIMEOUT, 5);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if (!$err) {
		file_put_contents($path . $outputfile, $output);

		return true;
	} else {
		return $err;
	}
}

function ajustVolume($path, $audio, $outputfile, $volume=1.0)
{
	try 
	{
		if (\Illuminate\Support\Facades\Storage::disk('videos')->exists($audio)) {
			$command = 'cd ' . $path . ' && ffmpeg -i ' . $audio . ' -filter:a "volume=' . $volume . '" -y ' . $outputfile;
			exec($command);
			unlink($path . $audio);

			return true;
		} else {
			return 'not found file';
		}
	}
	catch(Exception $exception)
	{
		return $exception->getMessage();
	} 
}

function formatTime($duration) //as hh:mm:ss
{
	$hours = floor($duration / 3600);
	$minutes = floor(($duration - $hours * 3600) / 60);
	$seconds = $duration - ($minutes * 60) - ($hours * 3600);
	return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}

function makeVideo($combineVideo, $ttsAudio, $bgAudio, $path)
{
	try
	{
		$command = 'cd ' . $path . '&& ffmpeg -i ' . $ttsAudio . ' -i ' . $bgAudio . ' -filter_complex amerge=inputs=2 -ac 2 -y combineAudio.mp3';
		exec($command);
		$outputfile = uniqid() . '_' . 'makeVideo.mp4';
		$command = 'cd ' . $path . '&& ffmpeg -i ' . $combineVideo . ' -i combineAudio.mp3 -c:v copy -c:a aac -shortest ' . $outputfile;
		exec($command);
		unlink($path . 'combineAudio.mp3');

		return array('error' => false, 'async' => $outputfile);
	}
	catch(Exception $exception)
	{
		return array('error' => true, 'message' => 'Lỗi khi tạo video');
	} 
}

function formatTimeDate($date) {
	$diff = $date->diffForHumans(null, true, true, 2);
	return str_replace(['h', 'm'], ['h', 'mins'], $diff);
}

function trimName($name)
{
	$name = str_replace(' ', '', $name); // Replaces all spaces with hyphens.
   	return preg_replace('/[^A-Za-z0-9\-]/', '', $name); // Removes special chars.
}

function removeSpecChra($str) {
	return str_replace(['(','[','{', '-', ')', '}', ']', '"', ':', '<', '>', '*', '|'], ' ', $str);
}