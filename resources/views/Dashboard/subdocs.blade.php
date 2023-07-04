<form class="row g-3" method="POST" action="/docs" enctype="multipart/form-data">
              {!! csrf_field() !!}
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="file" class="form-control" id="floatingName" accept=".pdf" placeholder="Berkas" name="document" 
                    required="">
                    <label for="floatingName">Upload Berkas</label>
                  </div>
                </div>
                <div>
                  <button type="submit" class="btn btn-primary" >Save</button>
                  <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
              </form><!-- End floating Labels Form -->
