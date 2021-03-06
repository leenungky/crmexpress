<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
     @include('head')
     <style type="text/css" media="print">
     	   @media print {
			    @page { margin: 0px 6px; }
  				body  { margin: 0px 6px; }   					  
			}
     </style>
</head>
<body >
    <?php use App\Http\Helpers\Helpdesk; ?>
 
 <div id="contents">
    <div class="container container-fluid">            	
		@include('header')		
		<br/>		
		<div class="row">	
			<div class="col-md-12">
			<a href="/cities/add">Create</a>
			</div>
		</div>
		<br/>
		<div class="row">	
			<div class="col-md-12">
				<table class="table">
					<?php 
						$str_parameter = "";
						if (isset($order_by)){
							if ($order_by=="asc"){
								$str_parameter = "&order_by=desc";
							}
							else if ($order_by=="desc"){
								$str_parameter = "&order_by=asc";
							}	
						}
					?>
					<thead>
						<th>Code</th>
			    		<th>City name</th>			    		
						<th>Action</th>
					</thead>
					<tbody>		
						@foreach ($cities as $key => $value)
							<tr>
								<td>{{$value->code}}</td><td>{{$value->name}}</td>
								<td>
									<a href="/cities/edit/{{$value->id}}">
										<span class="edit"> 
					    					<span class="glyphicon glyphicon-pencil"  rel="tooltip" title="delete"></span>
					    				</span>
				    				</a> | 
				    				<a href="/cities/delete/{{$value->id}}" class="confirmation">
					    				<span class="delete">
				    						<span class="glyphicon glyphicon-remove"  rel="tooltip" title="delete"></span>
				    					</span>
				    				</a> |
				    				<a href="/cities/setcitykecamatan/{{$value->id}}">
					    				<span class="delete">
				    						<span class="glyphicon glyphicon-random"  rel="tooltip" title="Set Kecamatan City"></span>
				    					</span>
				    				</a>
								</td>
							</tr>
						@endforeach						
					</tbody>
				</table>
			</div>
		</div>
	 </div>	    	
</div>
</body>
</html>