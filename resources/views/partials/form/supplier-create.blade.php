<div class="card">
    <div class="card-body">
        <form class="form" method="POST"
              action="{{url('/admin/supplier/store')}}">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input placeholder="Name" class="form-control" type="text" name="name"
                               value="{{old('name')}}">

                    </div>
                    <div class="form-group">
                        <label>Contact Name</label>
                        <input placeholder="Contact Name" class="form-control" type="text" name="contact_name"
                               value="{{old('contact_name')}}">
                    </div>
                    <div class="form-group">
                        <label>COntact Details</label>
                        <input placeholder="Contact Details" class="form-control" type="text" name="contact_details"
                               value="{{old('contact_details')}}">
                   </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="type">
                            <option value="car">Car</option>
                            <option value="tracker">Tracker</option>
                            <option value="sim">Sim</option>
                            <option value="camera">Camera</option>
                            <option value="garage">Garage</option>
                            <option value="insurance">Insurance</option>
                            <option value="mot">Mot</option>
                            <option value="pco">Pco</option>
                            <option value="road-side">Road-Side</option>
                            <option value="road-side">Repairs</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-btn fa-user"></i>Register Supplier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>