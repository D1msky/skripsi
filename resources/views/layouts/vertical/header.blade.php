<div class="main-header">
    <div class="header-toggle">
        <button type="button" class="btn btn-primary btn-icon m-1" >
            <span class="ul-btn__icon"><i class="i-Administrator"></i></span>
            <span class="ul-btn__text">{{auth()->user()->NAMA}}</span>
        </button>

    </div>
    <div style="margin: auto"></div>

    <div class="header-part-right">
        <!-- Full screen toggle -->

        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>



        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                @if(auth()->user()->JENIS_KELAMIN == 'L')
                <img src="{{asset('assets/images/faces/5.jpg')}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @else
                <img src="{{asset('assets/images/faces/12.jpg')}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                @endif

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> {{auth()->user()->NAMA}}
                    </div>

                    <a class="dropdown-item" href="/logout">Sign out</a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- header top menu end -->