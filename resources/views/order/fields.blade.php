<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('device_id', '1、输入app里面的设备ID:') !!}
    {!! Form::text('device_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('robots.index') !!}" class="btn btn-default">取消</a>
</div>
