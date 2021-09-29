
        <div class="card p-4">
            <form action="{{ url('/pegawai') }}" method="POST" class="needs-validator" novalidate>
                @csrf
                <div class="form-group">
                    <label for="">Nama Lengkap</label>
                  <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" placeholder="Nama Lengkap" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                <div class="invalid-feedback">
                    Nama Wajib Diisi
                </div>
                </div>
                <div class="form-group">
                    <label for="">nrp</label>
                <input type="tel" name="nrp" class="form-control" placeholder="nrp" value="{{ old('nrp') }}" required>
                  <div class="invalid-feedback">
                    nrp Wajib Diisi Minimal Sebanyak 21 & Berisikan Angka
                </div>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                  <div class="invalid-feedback">
                    nrp Wajib Diisi Minimal Sebanyak 21 & Berisikan Angka
                </div>
                </div>
                <div class="form-group">
                    <label for="">pangkat</label>
                    {{-- <input type="text" name="Nama" class="form-control" placeholder="Nama Lengkap" value="{{ old('Nama') }}" id="exampleInputPassword1"> --}}
                    <select name="pangkat" class="form-control" id="" required>
                        <option disabled selected value>Pilih pangkat</option>
                        <option value="Sekretariat" {{ old('pangkat') ==  "Sekretariat"  ? 'selected' : '' }}>Sekretariat</option>
                        <option value="Pengelolaan Barang Milik Daerah" {{ old('pangkat') ==  "Pengelolaan Barang Milik Daerah"  ? 'selected' : '' }}>Pengelolaan Barang Milik Daerah</option>  
                        <option value="Perbendaharaan" {{ old('pangkat') ==  "Perbendaharaan"  ? 'selected' : '' }}>Perbendaharaan</option>  
                        <option value="Akuntansi dan pelaporan" {{ old('pangkat') ==  "Akuntansi dan pelaporan"  ? 'selected' : '' }}>Akuntansi dan pelaporan</option>  
                        <option value="Anggaran" {{ old('pangkat') ==  "Anggaran"  ? 'selected' : '' }}>Anggaran</option>  
                    </select>
                    <div class="invalid-feedback">
                        pangkat Wajib Diisi
                    </div>
                  </div>
                <div class="form-group">
                    <label for="">Jabatan</label>
                  <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" value="{{ old('jabatan') }}" id="exampleCheck1" required>
                  <div class="invalid-feedback">
                    Jabatan Wajib Diisi
                </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ url('/pegawai') }}" class="btn btn-danger">Batal</a>
            </form>
        </div>

        <script>
            $(function () {
          
          $('#txtnumber').keydown(function (e) {
              var key = e.charCode || e.keyCode || 0;
              $text = $(this);
              if ( key !== 8 && key !== 15 && key !== 17) {
                  if ($text.val().length === 8) {
                      $text.val($text.val() + '-');
                  }
                  if ($text.val().length === 15) {
                      $text.val($text.val() + '-');
                  }
                  if ($text.val().length === 17) {
                      $text.val($text.val() + '-');
                  }
              }
          })
        </script>