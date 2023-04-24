<div class="content-wrapper">
  <section class="content">
   <div class="col-lg-10">
              <br>
    <h4><strong>  DETAIL DATA</strong></h4>
    <br>
    <table class="table"> 
      <tr>
        <th>Nama Project</th>
        <td><?php echo $detail->nama ?></td>
      </tr>
       <tr>
        <th>Keterangan</th>
        <td><?php echo $detail->keterangan ?></td>
      </tr>
      <tr>
        <th>Detail</th>
        <td><?php echo $detail->detail ?></td>
      </tr>
     
    </table>
    <a href="<?php echo base_url('admin') ?>" class="btn badge-primary" onclick >Back </a>
    <br><br><br><br>
  </section>
</div>