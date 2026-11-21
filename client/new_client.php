<?php
    // client/new.php
    $page = "Sign Up";
    include_once 'partials/client-header.php';

    $countries = countries();
?>

<div class="container bootstrap snippets bootdeys">
  <div class="row">
    <div class="col-xs-12 col-sm-9">
      <form
          id="customerRegistrationForm"
          action="index.php?page=client/create_client"
          method="POST"
          enctype="multipart/form-data"
      >

      <div class="card mb-4">
          <div class="card-body text-center">
              <img src="assets/rarity_banner.jpg" class="img-fluid">
          </div>
      </div>

      <!-- Personal Details -->
      <div class="card mb-4">
          <div class="card-header">
              <h4>Personal Details</h4>
          </div>

          <div class="card-body">

              <div class="form-group">
                  <label>Country</label>

                  <select name="country" class="form-control" required>
                      <option value="">Select Country</option>

                      <?php foreach ($countries as $country): ?>
                          <option value="<?php echo $country ?>">
                              <?php echo $country ?>
                          </option>
                      <?php endforeach; ?>

                  </select>
              </div>

              <div class="row">

                  <div class="col-md-6">
                      <label>First Name</label>

                      <input
                          type="text"
                          name="first_name"
                          id="first_name"
                          class="form-control"
                          required
                      >

                      <small
                          class="text-danger"
                          id="first_name_error"
                      ></small>
                  </div>

                  <div class="col-md-6">
                      <label>Last Name</label>

                      <input
                          type="text"
                          name="last_name"
                          id="last_name"
                          class="form-control"
                          required
                      >

                      <small
                          class="text-danger"
                          id="last_name_error"
                      ></small>
                  </div>

              </div>

              <div class="form-group mt-3">
                  <label>Date of Birth</label>

                  <input
                      type="date"
                      name="date_of_birth"
                      id="date_of_birth"
                      class="form-control"
                      required
                  >

                  <small
                      class="text-danger"
                      id="dob_error"
                  ></small>
              </div>

          </div>
      </div>

      <!-- Identification -->
      <div class="card mb-4">
          <div class="card-header">
              <h4>Identification</h4>
          </div>

          <div class="card-body">

              <div class="form-group">
                  <label>ID Type</label>

                  <select
                      name="id_type"
                      class="form-control"
                      required
                  >
                      <option value="">Select ID Type</option>
                      <option value="national_id">National ID</option>
                      <option value="passport">Passport</option>
                      <option value="military_id">Military ID</option>
                  </select>
              </div>

              <div class="form-group">
                  <label>ID Number</label>

                  <input
                      type="text"
                      name="id_number"
                      id="id_number"
                      class="form-control"
                      required
                  >
              </div>

              <div class="row">

                  <div class="col-md-6">
                      <label>ID Front</label>

                      <input
                          type="file"
                          name="id_image"
                          id="id_front"
                          class="form-control-file"
                          accept="image/*"
                          required
                      >

                      <img
                          id="id_front_preview"
                          class="img-fluid mt-2"
                          style="max-height:200px;display:none;"
                      >
                  </div>

                  <div class="col-md-6">
                      <label>ID Back</label>

                      <input
                          type="file"
                          name="id_image_back"
                          id="id_back"
                          class="form-control-file"
                          accept="image/*"
                          required
                      >

                      <img
                          id="id_back_preview"
                          class="img-fluid mt-2"
                          style="max-height:200px;display:none;"
                      >
                  </div>

              </div>

          </div>
      </div>

      <!-- Driving Licence -->
      <div class="card mb-4">
          <div class="card-header">
              <h4>Driving Licence</h4>
          </div>

          <div class="card-body">

              <div class="form-group">
                  <label>Licence Number</label>

                  <input
                      type="text"
                      name="dl_number"
                      id="dl_number"
                      class="form-control"
                      required
                  >
              </div>

              <div class="form-group">
                  <label>Licence Expiry</label>

                  <input
                      type="date"
                      name="dl_expiry"
                      id="dl_expiry"
                      class="form-control"
                      required
                  >
              </div>

              <div class="form-group">

                  <label>Licence Image</label>

                  <input
                      type="file"
                      name="license_image"
                      id="license_image"
                      class="form-control-file"
                      accept="image/*"
                      required
                  >

                  <img
                      id="license_preview"
                      class="img-fluid mt-2"
                      style="max-height:200px;display:none;"
                  >

              </div>

          </div>
      </div>

      <!-- Contact -->
      <div class="card mb-4">
          <div class="card-header">
              <h4>Contact Details</h4>
          </div>

          <div class="card-body">

              <div class="form-group">
                  <label>Phone</label>

                  <input
                      type="tel"
                      id="phone"
                      name="tel"
                      class="form-control"
                      required
                  >
              </div>

              <div class="form-group">
                  <label>Email</label>

                  <input
                      type="email"
                      id="email"
                      name="email"
                      class="form-control"
                      required
                  >
              </div>

              <div class="form-group">
                  <label>Work Address</label>

                  <input
                      type="text"
                      name="work_address"
                      class="form-control"
                  >
              </div>

              <div class="form-group">
                  <label>Residential Address</label>

                  <input
                      type="text"
                      name="residential_address"
                      class="form-control"
                  >
              </div>

          </div>
      </div>

      <!-- Profile Photo -->
      <div class="card">
        <div class="card-header">
            Profile Selfie
        </div>

        <div class="card-body">

            <video
                id="video"
                autoplay
                playsinline
                class="img-fluid"
            ></video>

            <canvas
                id="canvas"
                style="display:none;"
            ></canvas>

            <input
                type="hidden"
                name="profile_image"
                id="profile_image"
            >

            <div class="mt-3">

                <button
                    type="button"
                    class="btn btn-primary"
                    onclick="captureSelfie()"
                >
                    Take Selfie
                </button>

            </div>

            <img
                id="preview"
                class="img-fluid mt-3"
                style="display:none;"
            >

        </div>
      </div>

      <div class="text-center mb-5">
          <button
              type="submit"
              class="btn btn-primary btn-lg"
          >
              Complete Registration
          </button>
      </div>

      </form>
    </div>
  </div>
</div>

<?php include_once 'partials/client-footer.php'; ?>