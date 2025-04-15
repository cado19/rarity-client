
<?php
    // THIS PAGE ALLOWS A USER TO TAKE A SELFIE FOR CLIENT'S PROFILE IMAGE
    $page = "Capture Profile Picture";
    include_once 'partials/client-header.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
?>

<div class="container bootstrap snippets bootdeys">
	<div class="row">
	  <div class="col-xs-12 col-sm-12">


	      <div class="panel panel-default">
	        <div class="panel-body text-center">
	         <img src="assets/rarity_banner.jpg" class="img-fluid">
	        </div>
	      </div>

	      <div class="panel panel-default">
	        <div class="panel-heading">
		        <h4 class="panel-title">Capture Profile Picture</h4>
	        </div>

	        <div class="panel-body">
						<form class="form-horizontal" method="POST" action="index.php?page=client/profile_process" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<div class="form-group">
								<div id="my_camera"></div>

				                <input type=button value="Take Snapshot" onClick="take_snapshot()" class="text-center">


				                <input type="hidden" name="image" class="image-tag">
							</div>

				          <div class="form-group">
				            <div class="col-sm-6 col-sm-offset-4">
				              <button type="submit" class="btn btn-outline-primary">Submit</button>
				            </div>
				          </div>
						</form>
	        </div>


		    <!-- </div> -->

		    <div class="panel panel-default">
		      <div class="panel-heading">
			      <h4 class="panel-title">On mobile devices, scroll to the right to view full image</h4>
		      </div>
		    </div>

		    <div class="panel panel-default">
		    </div>


	      </div>



	  </div>
	</div>
</div>

<?php include_once 'partials/client-webcam-footer.php'; ?>
