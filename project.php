    
      <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

          

          <div class="row">
		      <div class="col-lg-6">

            <?= form_error('project','<div class="alert alert-danger" 
            role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>

            
 			<div class="container-fluid">
          	<div class="row text-center">
          		
          <?php foreach($project as $pr) : ?>
          	<div class="card" style="width: 16rem;">
			  <img src="<?php echo base_url().'/uploads/'.$pr['gambar']; ?>" class="card-img-top" alt="...">
			  <div class="card-body">
			    <h4 class="card-title mb-1"><?php echo $pr['nama']; ?></h4>
			    <p class="card-text"><?php echo $pr['keterangan']; ?></p>

			    <a href="#" class="btn btn-primary">Detail</a>
			    <a href="<?= base_url('link'); ?> ?>" class="badge badge-pill badge-success mb-3" onclick >Link</a>
			  </div>
			</div>
           
       	   <?php endforeach; ?>
          </tbody>
      </table>
          </div>			          	
          </div>		