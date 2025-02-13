@extends('layouts.layout')
@section('content')
<div class="p-3">
    <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>150</h3>
    
                  <p>Akta Perusahaan</p>
                </div>
                <div class="icon">
                  <i class="ion ion-folder"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>53</h3>
                  <p>Sewa menyewa</p>
                </div>
                <div class="icon">
                  <i class="ion ion-folder"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>44</h3>
    
                  <p>User Registrations</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>65</h3>
    
                  <p>Unique Visitors</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <div class="row">
            <div class="col-12 col-md-6">

              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Reminder Dokumen Sewa Menyewa</h3>
  
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                @if (isset($listSertifikatSewa) && $listSertifikatSewa->isNotEmpty())
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead class="text-center align-items-center">
                      <tr>
                        <th>No Dokumen</th>
                        <th>No Sertifikat</th>
                        <th>Tanggal Akhir Sertifikat</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach($listSertifikatSewa as $sertifikat)
                        <tr class="text-center items-center">
                            <td>{{ $sertifikat->no_dokumen }}</td>
                            <td>{{ $sertifikat->no_sertifikat }}</td>
                            <td>{{ \Carbon\Carbon::parse($sertifikat->tgl_akhir_sertifikat)->format('d-m-Y') }}</td>
                            <td><a href="{{route('sewaMenyewa.edit',$sertifikat->id )}}" class="btn-sm btn-primary">Update</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                    </table>
                  </div>
                </div>
                @endif
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Reminder Dokumen Akta Perusahaan</h3>
  
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.container-fluid -->
    </section>
</div>
@endsection