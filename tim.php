    
    
      <!-- Begin Page Content -->
     

      <?php 
      echo "<b><center><h2><strong>Team Support</strong></b></center></h2>"  ?><br>
      <div class="row text-center" style="position: relative; left: 15%; ">
        <?php foreach($tim as $tm) : ?>
            <div class="card" style="width: 16rem; margin-left: 20px; margin-bottom: 30px;" >
              <br>
  <center>
  <div class="card" > 
    <img src="<?php echo base_url().'/uploads/'.$tm['gambar']; ?>" style="width: 200px; height: 200px; border-radius: 0px; margin: auto; "  class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title "><?php echo $tm['nama']; ?></h5>
      <p class="card-text"><?php echo $tm['keterangan']; ?></p>
      <a href="<?php echo $tm['whatsapp']; ?>" class="fas fa-link badge badge-pill badge-success mb-0" onclick >Contact</a>
      <p class="card-text"><small class="text-muted">Joined since 10 November 2019</small></p>
       
    </div>
  </div> 
  
</div>
</center>

 
  <?php endforeach; ?>
         
      </body>
      </html>
    </div>
      