<script id="handlebars-preview-video" type="text/x-handlebars-template">
    <li class="dd-item" data-id="{{ file.index }}" data-new="0" data-deleted="0" fileName="{{trimName}}">
        <div class="dd-handle">
            <video src="{{ fileContent}}" width="281" controls>

            </video>
            <div class="info-video">
                <p>{{name}}</p>
                <p>{{file.sizeInMB}} MB</p>
            </div>
        </div>
        <div class="list-input">
            <input type="text" name="index[]" value="{{file.index}}" index="{{ name }}-{{ file.index }}-{{file.sizeInMB}}" fileName="{{ name }}" class="index">
            <span class="button-delete btn btn-danger btn-xs" data-owner-id="{{ file.index }}">
                <i class="fa fa-times" aria-hidden="true"></i>
            </span>
        </div>
    </li>
</script>