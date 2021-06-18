<script id="handlebars-filter-ai" type="text/x-handlebars-template">
    {{#if speeches}}
    <div class="mr-4">
        <label for="">Chọn giọng nói</label>
        <select name="speech" id="" class="form-control">
            {{#each speeches}}
            <option value="{{@key}}">{{this}}</option>
            {{/each}}
        </select>
    </div>
    {{/if}}
    {{#if speeds}}
    <div class="">
        <label for="">Tốc độ</label>
        <div class="speed-box">
            <input type="range" value="{{speeds.default}}" min="{{speeds.min}}" max="{{speeds.max}}" step="{{speeds.step}}" oninput="rangevalue.value=value" class="speed"/>
            <output id="rangevalue">{{speeds.default}}</output>
        </div>
    </div>
    {{/if}}
</script>
