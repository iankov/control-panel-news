<style>
    .btn-group .btn{opacity: 0.5;}
    .btn-group .btn.active{opacity: 1;}
</style>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.27/daterangepicker.min.css" />

<div class="box-header">
    <a href="{{icp_route('news')}}" class="btn btn-default">Cancel</a>
    <button type="button" class="btn btn-success" onclick="$('[name=submit_type]').val(1); $('#form').submit();">Save & Stay</button>
    <button type="button" class="btn btn-success" onclick="$('[name=submit_type]').val(0); $('#form').submit();">Save & Close</button>
</div>
<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" name="submit_type" value="0">
            @include('icp::forms.horizontal.text-group', ['name' => 'title', 'label' => 'Title', 'value' => old('title', $article->title)])
            @include('icp::forms.horizontal.text-group', ['name' => 'slug', 'label' => 'Slug', 'value' => old('slug', $article->slug)])
            @include('icp::forms.horizontal.select-group', [
                'name' => 'category_id',
                'label' => 'Category',
                'value' => old('category_id', $article->category_id),
                'items' => $categories->pluck('title', 'id'),
                'prepend' => [0 => ' - ']
            ])

            <div class="form-group">
                <label class="col-sm-2 control-label">Created</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input name="created_at" class="form-control" type="text" value="{{old('created', $article->created_at ? $article->created_at->format('Y-m-d H:i:s') : '')}}">
                    </div>
                </div>
            </div>

            @include('icp::forms.horizontal.text-group', ['name' => 'source', 'label' => 'Source', 'value' => old('source', $article->source)])
            @include('icp::forms.horizontal.text-group', [
                'name' => 'image',
                'label' => 'Image',
                'value' => old('import_id', $article->image),
                'attr' => ['style' => 'display: inline-block', 'id' => 'page_image']
            ])
        </div>

        <div class="col-md-6">
            @include('icp::forms.horizontal.text-group', ['name' => 'import_id', 'label' => 'Import ID', 'value' => old('import_id', $article->import_id)])
            @include('icp::forms.horizontal.textarea-group', ['name' => 'keywords', 'label' => 'Meta keywords', 'value' => old('keywords', $article->keywords)])
            @include('icp::forms.horizontal.textarea-group', ['name' => 'description', 'label' => 'Meta description', 'value' => old('description', $article->description)])
            @include('icp::forms.horizontal.checkbox-group', ['name' => 'active', 'value' => old('active', $article->active), 'label' => 'Active'])
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-1 control-label">Content</label>
        <div class="col-sm-11">
            <textarea class="form-control" id="editor" name="content">{{old('content', $article->content)}}</textarea>
        </div>
    </div>
</div>

<div class="box-footer">
    <a href="{{icp_route('news')}}" class="btn btn-default">Cancel</a>
    <button type="button" class="btn btn-success" onclick="$('[name=submit_type]').val(1); $('#form').submit();">Save & Stay</button>
    <button type="button" class="btn btn-success" onclick="$('[name=submit_type]').val(0); $('#form').submit();">Save & Close</button>
</div>

<!-- bootstrap datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.27/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.27/daterangepicker.min.js"></script>

<!-- CK Editor -->
<script src="//cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script>

<script>
    $(function () {
        Icp.iCheck('input[name=active]');
        $('input[name=created_at]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {format: 'YYYY-MM-DD HH:mm:ss'},
            timePicker: true,
            timePicker24Hour: true,
            timePickerSeconds: true
        });

        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.contentsCss = '/assets/web/style.css';
        CKEDITOR.config.bodyClass = 'block-content';
        CKEDITOR.replace('editor', {
            width: '800px',
            height: '700px',
            filebrowserImageBrowseUrl: '{{config('icp-news.ckeditor.file-browser-image-url')}}',
            //filebrowserImageUploadUrl: '/control/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',

            filebrowserBrowseUrl: '{{config('icp-news.ckeditor.file-browser-url')}}',
            //filebrowserUploadUrl: '/control/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'
        });
    });
</script>