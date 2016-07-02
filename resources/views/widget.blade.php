<!-- Small boxes (Stat box) -->
<div class="row no-print">
  
  <div class="col-lg-4 col-xs-6">
    <div class="info-box bg-aqua">
      <span class="info-box-icon"><i class="fa fa-puzzle-piece"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Sub Komponen</span>
        <span class="info-box-number">{{ $sub_komponens->count() }}</span>
      </div><!-- /.info-box-content -->
    </div>
  </div><!-- ./col -->

  <div class="col-lg-4 col-xs-6">
    <div class="info-box bg-red">
      <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>
      <div class="info-box-content">
        <?php
            $jumlah_datduks = $datduks->groupBy('parent')->count();
            $jumlah_subkom  = $sub_komponens->count();
            $percentage     = $jumlah_datduks / $jumlah_subkom *100
        ?>
        <span class="info-box-text">Data Dukung terkumpul</span>
        <span class="info-box-number">{{ round($percentage) }}%</span>
        <div class="progress">
          <div class="progress-bar" style="width: {{ $percentage }}%"></div>
        </div>
        <span class="progress-description"> 
          Terkumpul {{ $jumlah_datduks }} dari {{ $jumlah_subkom }} 
        </span>
      </div><!-- /.info-box-content -->
    </div>
  </div><!-- ./col -->

  <div class="col-lg-4 col-xs-6">
    <div class="info-box bg-green">
      <span class="info-box-icon"><i class="fa fa-money"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Anggaran</span>
        <span class="info-box-number">{{ number_format($kegiatans->sum(function ($kegiatan) {
                  return str_replace('.', '', $kegiatan['pagu']);
                }), "0", ",", ".") }}</span>
      </div><!-- /.info-box-content -->
    </div>
  </div><!-- ./col -->
</div><!-- /.row