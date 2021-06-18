<script id="handlebars-audios-1" type="text/x-handlebars-template">
    <audio preload="auto">
    <source src="{{asset}}{{fileName}}"></source>
    Your browser does not support the audio element.
</audio>

<div class="play-audio">
    <p class="track">{{fileName}}</p>
    <p>{{size}} MB<p>
    <button data-am-button="small" id="btn-mute-{{key}}"><i class="fa fa-volume-off"></i></button>
    <button data-am-button="large" id="btn-play-pause-{{key}}"><i class="fa fa-play"></i></button>
    <button data-am-button="small" id="btn-stop-{{key}}"><i class="fa fa-stop"></i></button>
    <p><span id="currentTime-{{key}}">00</span> : <span id="duration-{{key}}">{{duration}}</span></p>
    <div id="progress-bar-{{key}}"><span id="progress-{{key}}"></span></div>    
</div>  
</script>
