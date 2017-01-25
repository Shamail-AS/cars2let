<div class="sub-nav">
    <div class="sub-nav-item {{$cars or ''}}">
        <a href="{{url('admin/investor/'.$id.'/cars')}}"><p>Cars</p></a>
    </div>
    <div class="sub-nav-item {{$contracts or ''}}">
        <a href="{{url('admin/investor/'.$id.'contracts')}}"><p>Contracts</p></a>
    </div>
    <div class="sub-nav-item {{$drivers or ''}}">
        <a href="{{url('admin/investor/'.$id.'drivers')}}"><p>Drivers</p></a>
    </div>
</div>