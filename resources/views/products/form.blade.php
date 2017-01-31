@if (count($products) > 0)
	@foreach ($products as $product)
		<li id="form-{{$product['id']}}">
		    <div style=" padding: 10px ; margin: 10px; display: inline-block; " class="menuDiv">
                <div class="form-group" style="padding-bottom: 13px;">
                    <span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick">

                        </span>
                    <div class="deleteMenu btn btn-danger glyphicon glyphicon-remove" ></div>
                    &nbsp;
                </div>
                <br>
		        <table>
		        <tr>
		        <td>
		        <div class="form-group" style="margin-bottom: 10px;">
                                      <label for="name">نام :</label>
                                      <input type="text" class="form-control" name="name" placeholder="نام" value="{{$product['name']}}">
                                    </div>
                                    </td>
		        <td>
		        <div class="form-group" style="margin-bottom: 10px;">
                                                      <label for="name">نوع :</label>
                                                      <input type="text" class="form-control" name="type" placeholder="نوع" value="{{$product['type']}}">
                                    </div>
                                    </td>
		        </tr>
		        <tr>
		        <td>
		        <div class="form-group"  style="margin-bottom: 10px;">
                                      <label for="desc">توضیحات :</label>
                                      <input type="text" class="form-control" name="desc" placeholder="توضیحات" value="{{$product['desc']}}">
                                    </div>
                                    </td>
		        <td>
		        <div class="form-group"  style="margin-bottom: 10px;">
                                                      <label for="price">قیمت :</label>
                                                      <input type="text" class="form-control" name="price" placeholder="قیمت" value="{{$product['price']}}">
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
		    @if(isset($product['children']) && count($product['children'])>0)
		    	<ol>
		    		@include('products.form',['products'=>$product['children']])
		    	</ol>
		    @endif
		</li>
    @endforeach
@endif



