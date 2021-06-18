<script id="handlebars-list-film" type="text/x-handlebars-template">
	{{#each films}}
	<div class="col-md-3 w3l-movie-gride-agile">
		<a href="{{route}}" class="hvr-shutter-out-horizontal">
			<img src="{{ image }}" title="album-name" alt=" ">
			<div class="w3l-action-icon">
				<i class="fa fa-play-circle" aria-hidden="true">
				</i>
			</div>
		</a>
		<div class="mid-1">
			<div class="w3l-movie-text">
				<h6>
					<a href="{{route}}">{{ name }}</a>
				</h6>							
			</div>
			<div class="mid-2">

				<p>{{ year }}</p>
				<div class="block-stars">
					<ul class="w3l-ratings">
						<li>
							<a href="#">
								<i class="fa fa-star" aria-hidden="true">
								</i>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fa fa-star" aria-hidden="true">
								</i>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fa fa-star" aria-hidden="true">
								</i>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fa fa-star-half-o" aria-hidden="true">
								</i>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fa fa-star-o" aria-hidden="true">
								</i>
							</a>
						</li>


					</ul>
				</div>
				<div class="clearfix">
				</div>
			</div>

		</div>
		<div class="ribben two">
			<p>NEW</p>
		</div>	
	</div>
	{{/each}}
</script>