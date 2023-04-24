    
    
      <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-black-800"><?php echo $title; ?></h1>

      <div class="card">
        <h5 class="card-header">  >.< </h5>
        <div class="card-body">
          <h4 class="card-title">Welcome <?= $this->session->userdata('email');  ?></h4>
          <h1 class="h3 mb-4 text-gray-800"><?php echo $next; ?></h1>

          <a href="user/profile" class="btn btn badge-success">Profile</a>
        </div>
      </div>
          
<br><br><br>
         
        <?php echo "<b><center><h3>View The Project</b></center></h3>" ?>
            <div class="row text-center">
            
          <?php foreach($project as $pr) : ?>
            <div class="card" style="width: 15rem; margin-left: 20px; margin-bottom: 15px;">
              <br>
        <img src="<?php echo base_url().'/assets/img/uploads/'.$pr['gambar']; ?>" style="width: 200px; height: 200px; border-radius: 0px; margin: auto;" class="card-img-top" alt="...">
        <div class="card-body">
          <h4 class="card-title mb-0,5"><?php echo $pr['nama']; ?></h4>
          <p class="card-text"><?php echo $pr['keterangan']; ?></p>
          <td><?php echo anchor('admin/detail/'.$pr['id'], '<div class="btn btn-primary btn-sm"><i class="fas fa-search-plus">Detail</i></div>') ?></td>
          <a href="<?php echo $pr['link']; ?>" class="fas fa-link badge badge-pill badge-success mb-0" onclick >Link</a>
        </div>
      </div>
           <?php endforeach; ?>
          </tbody>
      </table>
          </div>                  
          </div>   
<br><br><br><br><br><br>

   



     