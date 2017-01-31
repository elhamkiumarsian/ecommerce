@extends('master')

@section('head')
    <style type="text/css">
        html {
            background-color: #eee;
        }

        body {
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            color: #444;
            background-color: #fff;
            font-size: 13px;
            font-family: Freesans, sans-serif;
            padding: 2em 4em;
            width: 860px;
            margin: 15px auto;
            box-shadow: 1px 1px 8px #444;
            -mox-box-shadow: 1px 1px 8px #444;
            -webkit-box-shadow: 1px -1px 8px #444;
        }

        a, a:visited {
            color: #4183C4;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        pre, code {
            font-size: 12px;
        }

        pre {
            width: 100%;
            overflow: auto;
        }

        small {
            font-size: 90%;
        }

        small code {
            font-size: 11px;
        }

        .placeholder {
            outline: 1px dashed #4183C4;
        }

        .mjs-nestedSortable-error {
            background: #fbe3e4;
            border-color: transparent;
        }

        #tree {
            width: 550px;
            margin: 0;
        }

        ol {
            max-width: 450px;
            padding-left: 25px;
        }

        ol.sortable, ol.sortable ol {
            list-style-type: none;
        }

        .sortable li div {
            border: 1px solid #d4d4d4;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            cursor: move;
            border-color: #D4D4D4 #D4D4D4 #BCBCBC;
            margin: 0;
            padding: 3px;
        }

        li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
            border-color: #999;
        }

        .disclose, .expandEditor {
            cursor: pointer;
            width: 20px;
            display: none;
        }

        .sortable li.mjs-nestedSortable-collapsed > ol {
            display: none;
        }

        .sortable li.mjs-nestedSortable-branch > div > .disclose {
            display: inline-block;
        }

        .sortable span.ui-icon {
            display: inline-block;
            margin: 0;
            padding: 0;
        }

        .menuDiv {
            background: #EBEBEB;
        }

        .menuEdit {
            background: #FFF;
        }

        .itemTitle {
            vertical-align: middle;
            cursor: pointer;
        }

        .deleteMenu {
            float: right;
            cursor: pointer;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 0;
        }

        h2 {
            font-size: 1.2em;
            font-weight: 400;
            font-style: italic;
            margin-top: .2em;
            margin-bottom: 1.5em;
        }

        h3 {
            font-size: 1em;
            margin: 1em 0 .3em;
        }

        p, ol, ul, pre, form {
            margin-top: 0;
            margin-bottom: 1em;
        }

        dl {
            margin: 0;
        }

        dd {
            margin: 0;
            padding: 0 0 0 1.5em;
        }

        code {
            background: #e5e5e5;
        }

        input {
            vertical-align: text-bottom;
        }

        .notice {
            color: #c33;
        }


    </style>
@endsection


@section('content')

    <ol class="sortable">
        <li id="form-0" hidden="hidden">
            <div style=" padding: 10px ; margin: 10px; display: inline-block; " class="menuDiv">
                <div class="form-group" style="padding-bottom: 13px;">
                        <span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick">

                            </span>

                    <div class="deleteMenu btn btn-danger glyphicon glyphicon-remove"></div>
                    &nbsp;
                </div>
                <br>
                <table>
                    <tr>
                        <td>
                            <div class="form-group" style="margin-bottom: 10px;">
                                <label for="name">نام :</label>
                                <input type="text" class="form-control" name="name" placeholder="نام">
                            </div>
                        </td>
                        <td>
                            <div class="form-group" style="margin-bottom: 10px;">
                                <label for="name">نوع :</label>
                                <input type="text" class="form-control" name="type" placeholder="نوع">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group" style="margin-bottom: 10px;">
                                <label for="desc">توضیحات:</label>
                                <input type="text" class="form-control" name="desc" placeholder="توضیحات">
                            </div>
                        </td>
                        <td>
                            <div class="form-group" style="margin-bottom: 10px;">
                                <label for="price">مبلغ :</label>
                                <input type="text" class="form-control" name="price" placeholder="مبلغ" ">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="form-group" style="margin-bottom: 10px;">
                                <label for="pic">تصویر:</label>
                                <input type="file" name="pic" class="form-control">
                            </div>
                        </td>

                    </tr>
                </table>
            </div>
        </li>
        @include('products.form',compact('products'))


    </ol>

    <div id="add" class="btn btn-warning glyphicon glyphicon-plus"
         style="position: fixed;top: 45%;left: 10px;overflow-y: auto; font-size: 50px;"></div>
    <div id="btnSend" class="btn btn-success glyphicon glyphicon-floppy-save"
         style=";position: fixed;top: 60%;left: 10px;overflow-y: auto; font-size: 50px;"></div>


@endsection


@section('js')
    <script type="text/javascript">

        $(document).ready(function () {
            arr = '';
            formdata = new FormData();
            $('ol').on('click', '.deleteMenu', function (events) {
                $(this).parents('li').first().remove();
            });

            $('.sortable').nestedSortable({
                handle: 'div',
                items: 'li',
                toleranceElement: '> div'
            });

            $("#btnSend").click(function () {
                window.arr = $(".sortable").nestedSortable('toHierarchy');
                handle(window.arr);
                console.log(JSON.stringify(window.arr));
                window.formdata.append('data', JSON.stringify(window.arr));
                window.formdata.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: '{{ asset("/Products/Add") }}',
                    method: "POST",
                    //contentType: 'multipart/form-data',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    {{--{--}}
                    {{--_token: '{{ csrf_token() }}' ,--}}
                    {{--//data : JSON.stringify(window.arr)--}}
                    {{--data : formdata--}}
                    {{--}--}}
                }).done(function (msg) {
                    alert(msg);
                    location.reload(true);
                }).fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            });


            $("#add").click(function () {

                last_id = $("li").length - 1;
                new_id = last_id + 1;

                li = "<li id='form-" + new_id + "'>" + $("#form-0").html() + "</li>";
                $('ol.sortable').append(li);
            });
            function set(i, val) {
                arr[i]['pic'] = val;
            }

            function handle(arr) {
                arr.forEach(function (j, i) {

                    if (typeof j['id'] != 'undefined' && j['id'] != 0) {
                        j['name'] = $('#form-' + j['id'] + " :input[name='name']").val();
                        j['type'] = $('#form-' + j['id'] + " :input[name='type']").val();
                        j['desc'] = $('#form-' + j['id'] + " :input[name='desc']").val();
                        j['price'] = $('#form-' + j['id'] + " :input[name='price']").val();
                        //j['pic'] = $('#form-' + j['id'] + " :input[name='pic']").val();
                        window.formdata.append(j['id'], $('#form-' + j['id'] + " :input[name='pic']")[0].files[0]);
//                    reader.onloadend = function () {
//                       j['pic'] = reader.result;
//                    };
//                    if (file) {
//                        reader.readAsDataURL(file);
//                    }


                    }
                    if (typeof j['children'] != 'undefined') {
                        handle(arr[i]['children']);
                    }


                });

            }


            $('.disclose').on('click', function () {
                $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
                $(this).toggleClass('ui-icon-plusthick').toggleClass('ui-icon-minusthick');
            });


        });
    </script>
@endsection