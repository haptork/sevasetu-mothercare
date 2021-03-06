<?php 
$tag=isset($searchTag)?$searchTag:"";
if($tag!="")
	$display="display:block;";
else 
	$display="display:none;";
$languagedata= DB::table('mct_language')->where('e_status', 'Active')->orderBy('bi_id', 'ASC')->get();
?>
@include('template/admin_title')
@include('template/admin_cssscripta')
</head>
<body>
@include('template/admin_header')
@include('template/admin_sidebar')
<div id="content">
	<div id="content-header">
    	<h1><?php echo trans('routes.fieldworker'); ?></h1>
	</div>
	<div id="breadcrumb">
    	<a href="<?php echo Config::get('app.url'); ?>admin/dashboard" title="<?php echo trans('routes.fieldworker'); ?>" class="tip-bottom"><i class="icon-home"></i> <?php echo trans('routes.fieldworker'); ?></a><a class="current"><?php echo trans('routes.fieldworker'); ?></a> 
   	</div>
	<div class="container-fluid"> 
    <br>
    	<div class="span10" style="margin-left:0;">
    	<div class="span4" style="float:left;">
    	<div style="width: 20%"><?php echo trans('routes.search'); ?></div>
		<div style="width: 80%;position: relative;" id="keywordtextbox">
			<input placeholder="<?php echo trans('routes.searchlabel'); ?>" type="text" name="searchadministrator" id="searchadministrator" style="width:99%;" class="input-new search-input" title="<?php echo trans('routes.searchlabel'); ?>" value="<?php echo $tag; ?>" onKeyUp="clearText(this.id)" >
			<?php if($tag!=""){?>
				<a class="search-reset searchadministrator" id="search-reset" style="<?php echo $display; ?>" href="<?php echo Config::get('app.url').'admin/fieldworkers'?>"></a>
			<?php }else{?>
				<div class="search-reset searchadministrator" id="search-reset" onClick="hidesearch(this.id);"></div>
			<?php }?>
        </div>
    	</div>
        <div class="span5" style="float:right;">
        <span class="insertDelMultipleButton">
  			<a href="<?php echo Config::get('app.url'); ?>admin/fieldworkers/edit" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i> <?php echo trans('routes.addfw'); ?></a>
    		<a href="javascript:void(0);" onClick="return checkDelete();" class="btn btn-danger"><i class="icon-remove icon-white"></i> <?php echo trans('routes.deletefw'); ?></a>
  		</span>
        	</div>
        </div>
        <?php echo Session::get('message'); ?>
        <?php  
			//$attributes = array('class' => 'form-horizontal', 'id' => 'frmList', 'name' => 'frmList');
			//echo form_open(SITEURLADM.$cntrlName.'/deleteSelected',$attributes);?>
		   	<?php //echo $this->session->flashdata('dispMessage');?>
		   	<form class="form-horizontal" accept-charset="utf-8" role="form" method="POST" id="frmList" name="frmList" action="<?php echo Config::get('app.url').'admin/fieldworkers/deleteSelected'; ?>">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row-fluid">
				<div class="span12">
					<div class="widget-box">
						<div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
				            <h5><?php echo trans('routes.fieldworker'); ?></h5>
          				</div>
			 		<div class="widget-content">
			 <div id="replace_pagecontant">
			 
		<div id="no-more-tables">
                    <div id="service_table" class="service_table">
                    <table class="table table-hover with-check table-condensed cf">
                       <thead class="cf mar-btn">
                       
         	
                <tr>
                  <th><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" onClick="checkedAll('frmList');" /></th>
                  <th>{{{ trans('routes.uniqueid') }}}</th>
                  <th>{{{ trans('routes.username') }}}</th>
				  <th>{{{ trans('routes.email') }}}</th>
				  <th>{{{ trans('routes.language') }}}</th>
				  <th>{{{ trans('routes.phonenumber') }}}</th>
				  <th>{{{ trans('routes.profession') }}}</th>
				  <th>{{{ trans('routes.action') }}}</th>
                </tr>
              </thead>
              <?php if(count($result) > 0) {?>
              <tbody>
              	<?php foreach ($result as $value){
              		$check="";
              		foreach ($languagedata as $lang){
              			if($value->v_language!=""){
              				$lanarr=explode(",", $value->v_language);
              				if(in_array($lang->bi_id,$lanarr))
              					$check.=$lang->v_language.", ";
              			}
              		}
              	?>
			        <tr>
                      <td><input type="checkbox" name="chkCheckedBox[]" id="chkCheckedBox" value="<?php echo $value->bi_id; ?>_<?php echo $value->bi_user_login_id; ?>" /></td>
                      	<td data-title="{{{ trans('routes.uniqueid') }}}"><a href="<?php echo Config::get('app.url').'admin/fieldworkers/view/'.Hashids::encode($value->bi_id) ?>"><?php echo $value->v_unique_code;?></a></td>
                        <td data-title="{{{ trans('routes.username') }}}"><a href="<?php echo Config::get('app.url').'admin/fieldworkers/view/'.Hashids::encode($value->bi_id) ?>"><?php echo $value->v_name;?></a></td>
                      	<td data-title="{{{ trans('routes.email') }}}"><?php echo $value->v_email;?></td>
						<td data-title="{{{ trans('routes.language') }}}"><?php echo ucwords(trim(trim($check),","));?></td>
						<td data-title="{{{ trans('routes.phonenumber') }}}"><?php echo $value->v_phone_number;?></td>
					  	<td data-title="{{{ trans('routes.profession') }}}"><?php echo ucfirst($value->v_profession);?></td>
					  	<td data-title="{{{ trans('routes.action') }}}">
     <div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Options
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="<?php echo url().'/admin/fieldworkers/edit/'.Hashids::encode($value->bi_id) ?>"><img id="detail-icon-img" src="{{ url() }}/external/img/edit.png" alt="deactivate" > {{ trans('routes.edit') }}</a></li>
 	 <?php if($value->e_status=="Active"){?>
   		 <li><a href="<?php echo url().'/admin/fieldworkers/delete/'.Hashids::encode($value->bi_id)."/".Hashids::encode($value->bi_user_login_id)."/".Hashids::encode(0); ?>"><img id="detail-icon-img" src="{{ url() }}/external/img/disable.png" alt="deactivate" > {{ trans('routes.inactive')}}</a></li>
	 <?php }elseif($value->e_status=="Inactive"){?>
  		 <li><a href="<?php echo url().'/admin/fieldworkers/delete/'.Hashids::encode($value->bi_id)."/".Hashids::encode($value->bi_user_login_id)."/".Hashids::encode(1); ?>"><img id="detail-icon-img" src="{{ url() }}/external/img/check.png" alt="deactivate" > {{ trans('routes.active')}}</a></li>
	<?php } ?>
  </ul>
</div>

					  	<?php /*	<a class="btn btn-info" href="<?php echo Config::get('app.url').'admin/fieldworkers/edit/'.Hashids::encode($value->bi_id) ?>"><i class="icon-edit icon-white"></i><?php echo trans('routes.edit'); ?></a>
							<!--  a class="btn btn-danger" onclick="return singleCheckDel();" href="<?php echo Config::get('app.url').'admin/fieldworkers/delete/'.Hashids::encode($value->bi_id)."/".Hashids::encode($value->bi_user_login_id); ?>"><i class="icon-remove icon-white"></i><?php echo trans('routes.delete'); ?></a>-->
                      		<?php if($value->e_status=="Active"){?>
                      			<a class="btn btn-info" href="<?php echo Config::get('app.url').'admin/fieldworkers/delete/'.Hashids::encode($value->bi_id)."/".Hashids::encode($value->bi_user_login_id)."/".Hashids::encode(0); ?>"></i><?php echo trans('routes.inactive'); ?></a>					  	
                      		<?php }elseif($value->e_status=="Inactive"){?>
                      			<a class="btn btn-info" href="<?php echo Config::get('app.url').'admin/fieldworkers/delete/'.Hashids::encode($value->bi_id)."/".Hashids::encode($value->bi_user_login_id)."/".Hashids::encode(1); ?>"></i><?php echo trans('routes.active'); ?></a>					  	
                      		<?php } */?>
                      	</td>
                        </td>
                        
                    </tr>                	
                <?php } ?>
              </tbody>
              <?php } else { ?>
              <tbody>
              	  <tr>
                    <td colspan="10"><center><em><?php echo trans('routes.norecord'); ?></em></center></td>
                  </tr>
              </tbody>
              <?php } ?>
            </table>
          </div></div>
          <!-- End No More Tables -->
          
            </div>
          </div>
           </div>
      </div>
      
       <div class="widget-box">
       <div class="pagination" style="float:right;clear:both;"><?php echo $result->render(); ?></div>
       </div>
    </div>
    </form>
    @include('template/admin_footer')
  </div>
</div>
@include('template/admin_jsscript')
<script>
	var siteurl="<?php echo Config::get('app.url')?>";
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip();
	});
  /*  $(window).on('hashchange', function() {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else {
                getPosts(page);
            }
        }
    });

    $(document).ready(function() {
        $(document).on('click', '.pagination a', function (e) {
            getPosts($(this).attr('href').split('page=')[1]);
            e.preventDefault();
        });
    });

    function getPosts(page) {
        $.ajax({
            url : siteurl+'admin/fieldworkers?page=' + page,
            dataType: 'html',
        }).done(function (data) {
            $('#replace_pagecontant').html(data);
            location.hash = page;
        }).fail(function () {
        	alert('Posts could not be loaded.');
        });
    }
*/
    </script>

  <script language="javascript" type="text/javascript">

					$('#searchadministrator').bind('keypress', function(e) 

					{
						$("#search-reset").show();	

						if(e.keyCode==13)

						{

						  if(!$('#hdnData').val())	

						  {		

							  var value = $('#searchadministrator').val();

							  if(value !=""){		  

							  window.location="<?php echo Config::get('app.url'); ?>admin/fieldworkers/searchdatafieldworker?search="+encodeURIComponent(value);

							  }

						  }	  

						}

					});

					

					$("#searchadministrator").coolautosuggest({

						

						url:"<?php echo Config::get('app.url'); ?>admin/fieldworkers/autocompletefieldworker?chars=",

						idField:$("#hdnData"),

					//	submitOnSelect:true,

						onSelected:function(result){

							if(result.fullname==1)

							{

									var fullname=result.fullname;	

							}

						  // Check if the result is not null

						  if(result!=null)

						  {				

						  				  				  

						  		window.location="<?php echo Config::get('app.url'); ?>admin/fieldworkers/searchdatafieldworker/"+result.id+'/'+result.data;

						  }						 

						},		

					});

				</script> 

