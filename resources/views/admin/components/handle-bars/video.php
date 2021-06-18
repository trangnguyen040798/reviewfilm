<script id="handlebars-videos-1" type="text/x-handlebars-template">
    <video width="320" height="240" controls {{#if autoplay}} autoplay {{/if}}>
        <source src="{{asset}}{{name}}" type="video/mp4">
    </video>
    <p>{{ name }}</p>
    <p>{{ size }} MB</p>
</script>
