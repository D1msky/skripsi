<!-- start sidebar -->
<div class="sidebar-panel">
    <div class="gull-brand pr-3 text-center mt-4 mb-2 d-flex justify-content-center align-items-center">
        <img class="pl-3" src="{{ asset('assets/images/logo.png') }}" alt="">
        <!-- <span class=" item-name text-20 text-primary font-weight-700">GULL</span> -->
        <div class="sidebar-compact-switch ml-auto"><span></span></div>

    </div>
    <!-- user -->
    <div class="scroll-nav" data-perfect-scrollbar data-suppress-scroll-x="true">

        <!-- user close -->
        <!-- side-nav start -->
        <div class="side-nav">

            <div class="main-menu">
                <ul class="metismenu" id="menu">

                    @if(auth()->user()->status->NAMA_STATUS == "Admin")
                    <li class="Ul_li--hover">
                        <a class="item-name" href="{{url('/')}}">
                            <i class="i-Bar-Chart text-20 mr-2 text-muted"></i>
                            <span class="item-name  text-muted">Dashboard</span>
                        </a>
                    </li>
                    <li class="Ul_li--hover">
                        <a class="item-name" href="{{url('/user')}}">
                            <i class="i-Administrator text-20 mr-2 text-muted"></i>
                            <span class="item-name  text-muted">User</span>
                        </a>
                    </li>
                    <li class="Ul_li--hover">
                        <a class="item-name" href="{{url('/fakultas')}}">
                            <i class="i-University text-20 mr-2 text-muted"></i>
                            <span class="item-name  text-muted">Fakultas</span>
                        </a>
                    </li>
                    <li class="Ul_li--hover">
                        <a class="item-name" href="{{url('/prodi')}}">
                            <i class="i-Building text-20 mr-2 text-muted"></i>
                            <span class="item-name  text-muted">Prodi</span>
                        </a>
                    </li>
                    <li class="Ul_li--hover">
                        <a class="item-name" href="{{url('/matakuliah')}}">
                            <i class="i-File-Clipboard-File--Text text-20 mr-2 text-muted"></i>
                            <span class="item-name  text-muted">Matakuliah</span>
                        </a>
                    </li>
                    <li class="Ul_li--hover">
                        <a class="item-name" href="{{url('/kelas')}}">
                            <i class="i-Conference text-20 mr-2 text-muted"></i>
                            <span class="item-name  text-muted">Kelas</span>
                        </a>
                    </li>
                    <li class="Ul_li--hover">
                        <a class="item-name" href="{{url('/cpl')}}">
                            <i class="i-Open-Book text-20 mr-2 text-muted"></i>
                            <span class="item-name  text-muted">CPL</span>
                        </a>
                    </li>
                    

                    @elseif(auth()->user()->status->NAMA_STATUS == "Kaprodi")
                    <li class="Ul_li--hover">
                        <a class="has-arrow" href="#">
                            <i class="i-Bar-Chart text-20 mr-2 text-muted"></i>
                            <span class="item-name  text-muted">Dashboard</span>
                        </a>
                        <ul class="mm-collapse">
                            <li class="item-name">
                                <a class="" href="{{url('/')}}">
                                    <i class="i-Circular-Point  mr-2 text-muted"></i>
                                    <span class=" text-muted">Kaprodi</span>
                                </a>
                            </li>
                            <li class="item-name">
                                <a class="" href="{{url('/dashdosen')}}">
                                    <i class="i-Circular-Point  mr-2 text-muted"></i>
                                    <span class=" text-muted">Dosen</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="Ul_li--hover">
                        <a class="item-name" href="{{url('/dafmatkul')}}">
                            <i class="i-Conference text-20 mr-2 text-muted"></i>
                            <span class="item-name  text-muted">Kelas</span>
                        </a>
                    </li>
                    <li class="Ul_li--hover">
                        <a class="item-name" href="{{url('/setprodi')}}">
                            <i class="i-Building text-20 mr-2 text-muted"></i>
                            <span class="item-name  text-muted">Prodi</span>
                        </a>
                    </li>

                    <li class="Ul_li--hover">
                        <a class="has-arrow" href="#">
                            <i class="i-Open-Book text-20 mr-2 text-muted"></i>
                            <span class="item-name  text-muted">CPL</span>
                        </a>
                        <ul class="mm-collapse">
                            <li class="item-name">
                                <a class="" href="{{url('/cplprod')}}">
                                    <i class="i-Circular-Point  mr-2 text-muted"></i>
                                    <span class=" text-muted">CPL Matakuliah</span>
                                </a>
                            </li>
                            <li class="item-name">
                                <a class="" href="{{url('/cplmatkulprod')}}">
                                    <i class="i-Circular-Point  mr-2 text-muted"></i>
                                    <span class=" text-muted">Persebaran CPL</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="Ul_li--hover">
                        <a class="item-name" href="{{url('/')}}">
                            <i class="i-Bar-Chart text-20 mr-2 text-muted"></i>
                            <span class="item-name  text-muted">Dashboard</span>
                        </a>
                    </li>
                    <li class="Ul_li--hover">
                        <a class="item-name" href="{{url('/dafmatkul')}}">
                            <i class="i-Conference text-20 mr-2 text-muted"></i>
                            <span class="item-name  text-muted">Kelas</span>
                        </a>
                    </li>
                    @endif


                </ul>
            </div>
        </div>
    </div>

    <!-- side-nav-close -->
</div>
<!-- end sidebar -->
<div class="switch-overlay"></div>