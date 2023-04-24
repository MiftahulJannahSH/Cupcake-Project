    
   <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

          <div class="row">
            <div class="col-lg-6">
              <?= $this->session->flashdata('message');?>
            </div>
          </div>

          <div class="card mb-6 col-lg-6" style="max-width: 540px;">
  <div class="row no-gutters">

    <div class="col-md-4  ">
      <br>
      <img src="<?= base_url('assets/img/profile/').$user['image']; ?>" style="width: 175px; height: 170px; border-radius: 0px; margin: auto;" class="card-img-top" alt="..." >

      
    </div>

    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title"><?php echo $user['name'];?></h5>
        <p class="card-text"><?php echo $user['email'];?></p>
        <p class="card-text"><small class="text-muted">Member since <?= date('d F Y', $user['date_created']);?></small></p>
        <a href ="edit" class="badge badge-pill badge-success mb-3" onclick >Update</a> 

      </div>
      <br>
    </div>
  </div>
</div>


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
