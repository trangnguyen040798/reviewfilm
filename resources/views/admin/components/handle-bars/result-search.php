<script id="handlebars-result-search" type="text/x-handlebars-template">
    <ul>
    	{{#each data}}
    	<li film_id="{{ film_id }}">
    		<p class="film_name">{{ film_name }}</p>
    		<p>Được tạo bởi {{ user_name }}</p>
    	</li>
    	{{/each}}
    </ul>
</script>