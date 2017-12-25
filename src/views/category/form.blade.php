<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            @include('icp::forms.horizontal.text-group', ['label' => 'Title', 'name' => 'title', 'value' => old('title', $category->title)])
            @include('icp::forms.horizontal.text-group', ['label' => 'Slug', 'name' => 'slug', 'value' => old('slug', $category->slug), 'attr' => ['placeholder' => 'Leave empty to generate automatically']])
            @include('icp::forms.horizontal.textarea-group', ['name' => 'keywords', 'label' => 'Meta keywords', 'value' => old('keywords', $category->keywords)])
            @include('icp::forms.horizontal.textarea-group', ['name' => 'description', 'label' => 'Meta description', 'value' => old('description', $category->description)])
            @include('icp::forms.horizontal.checkbox-group', ['name' => 'active', 'value' => old('active', $category->active), 'label' => 'Active'])
        </div>

        <div class="col-md-6">

        </div>
    </div>
</div>

<div class="box-footer">
    <a href="{{icp_route('news.categories')}}" class="btn btn-default">Cancel</a>
    <button type="submit" class="btn btn-success">Save</button>
</div>

<script type="text/javascript">
    $(function(){
        Icp.iCheck('input[name=active]');
    });
</script>