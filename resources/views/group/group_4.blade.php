@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <section class="content-header">
        <h1 class="pull-left">红包自动回复</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('robots.create') !!}">添加机器人</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="">
                <p>
                    注意：请保持机器人在线，否则将无法自动回复消息。</p>
                <p></p>
            </div>
            {!! Form::open(['url' => '/group/addauto','files' => true, 'method'=>'POST']) !!}
            <input type="hidden" name="robot_type" value="4">
            <input type="hidden" name="request_url" value="{{$request_url}}">
            <div class="box-body">
                <div class="box box-primary">
                    <div class="box-body">
                        {!! Form::label('robot_id', '微信号:  ') !!}
                        @foreach($robot as $k=>$v)
                            <label class="checkbox-inline">
                                <input type="checkbox"  @if(isset($select[$k])&&$k==$select[$k]) checked="checked"@endif onclick="aa()" id="'robot_id" name="robot_id[]" value="{{$k}}" />{{$v}}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-body">
                        <label class="">
                            {!! Form::label('status', '状态:') !!}
                            {!! Form::radio('status', '1', isset($wxdata->status)&&$wxdata->status==1?true:false) !!} 开启
                            {!! Form::radio('status', '0', isset($wxdata->status)&&$wxdata->status==0?true:false) !!} 关闭

                        </label>
                        <label class="checkbox-inline">
                            {!! Form::label('type', '每天开启时段:') !!}
                            {!! Form::text('start', isset($wxdata->start)&&$wxdata->start>0?$wxdata->start:0, ['placeholder' => '开启整点时间,最小0']) !!}到
                            {!! Form::text('end', isset($wxdata->end)&&$wxdata->end>0?$wxdata->end:0, ['placeholder' => '结束整点时间，最大24']) !!}
                        </label>
                        <label class="">
                            {!! Form::label('sex', '性别:') !!}
                            {!! Form::radio('sex', '0', isset($wxdata->sex)&&$wxdata->sex==0?true:false) !!} 所有
                            {!! Form::radio('sex', '1', isset($wxdata->sex)&&$wxdata->sex==1?true:false) !!} 男
                            {!! Form::radio('sex', '2',isset($wxdata->sex)&&$wxdata->sex==2?true:false) !!} 女
                            {!! Form::label('interval', '间隔时间:') !!}
                            {!! Form::text('interval', $wxdata->interval>0?$wxdata->interval:0, ['placeholder' => '间隔时间']) !!}分钟

                        </label>
                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-body">
                        选择加好友的群： 已添加0人，共X人。</br></br>
                        @foreach($group as $k=>$v)
                            <label class="checkbox-inline">
                                <input type="checkbox" @if($v['status']==1) checked @endif  onclick="" id="'group" name="group[]" value="{{$v['name']}}" />{{$v['sname']}}
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>
            <div class="box box-primary">
                <div class="box-body">
                    控件类型：
                    <select id="control"  name ="control" class="control" style="width:130px;">
                        <option value="1" @if($wxdata->control==1) selected @endif>文字</option>
                        <option value="2" @if($wxdata->control==2) selected @endif>图片</option>
                        <option value="3" @if($wxdata->control==3) selected @endif>视频</option>
                    </select>
                    </br>
                    </br>
                    <input type="hidden" id="default_control" value="{{$wxdata->control}}">
                    <div class="control_1">
                        {{--                @if($wxdata->control==1)--}}
                        {{ Form::textarea('msg',  $wxdata->msg?$wxdata->msg:'哈喽～很高兴认识你呢!如果有什么问题可以留言，我会尽快回复～么么哒', ['class'=>'form-control', 'row'=>'6']) }}
                        {{--@endif--}}
                    </div>
                    <div class="control_2">
                        @if($wxdata->control==2)
                            <img  style="width: 400px;" src="{{$wxdata->msg}}">
                        @endif
                        @if($wxdata->control==3)
                            <video width="320" height="240" controls>
                                <source src="{{$wxdata->msg}}" type="video/mp4">
                            </video>
                        @endif
                        <div class="timg">
                            {!! Form::file('img') !!}
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
    <script type="text/javascript">
        function aa(){

            var obj = $('[name="robot_id[]"]');
            check_val = [];
            key= [];
            i=0;
            obj.attr("checked",false);
            for(k in obj){
                if(obj[k].checked && obj[k].value != "0")
                    check_val.push(obj[k].value);
                if(obj[k].checked==1){
                    check_val = obj[k].value;
                }else{
                    obj[k].checked=false;
                }

                key.push(obj[k].key);
                i++;

            }
            var url = '/group/saveRobotId?robot_id='+check_val+'&save_type=4';
            $("#sampling").val(url);
            if(check_val==''){
                check_val = 0;
            }
            $.ajax({

                type: "post",

                url: url,

                data: {"robot_id":check_val, '_token':'{{csrf_token()}}','key':key},

                dataType: "json",

                success: function(data){
                    location.reload();
                },



            });
            // window.location.href= url;
            document.getElementById("links").href=url;
        }
        function setAllNo(){
            var box = document.getElementById("boxid");
            var loves = document.getElementsByName("love");
            if(box.checked == false){
                for (var i = 0; i < loves.length; i++) {
                    loves[i].checked = false;
                }
            }else{
                for (var i = 0; i < loves.length; i++) {
                    loves[i].checked = true;
                }
            }
        }

        var default_control = $('#default_control').val();
        if(default_control==1){
            $('.control_2').hide();
        }
        if(default_control==2||default_control==3){
            $('.control_1').hide();
        }
        $(".control").change(function(){
            key= [];
            var control = $('.control option:selected').val();//获取id
            if(control==1){
                $('.timg').hide();
                $('.control_1').show();
                $('.control_2').hide();
            }
            if(control==2||control==3){
                $('.timg').show();
                $('.control_1').hide();
                $('.control_2').show();
            }


        });
    </script>
@endsection

