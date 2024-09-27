<div class="sidebar sidebar-main sidebar-default">
    <div class="sidebar-content">

        <!-- 
        #0d004c
        #ffcd05
         -->

        @php
            $monthNow = date("Y-m");
            $runningMonth = date("Y-m", strtotime("-1 months"));
            $runningYear = date("Y");
        @endphp

        <!-- User Menu -->
        <!-- <div class="category-content sidebar-user">
            <div class="media">
                <a href="#" class="media-left"><img src="{!! url("assets/logo-user-1.png")  !!}" alt="foto"></a>
                <div class="media-body">
                    <span class="media-heading text-semibold">{{ session("admin_session")->U_FULLNAME }}</span>
                    <div class="text-size-mini text-muted">
                        <i class="icon-users"></i>  &nbsp;{{ Helper::getReferenceInfo("GROUP_ROLE", session("admin_session")->U_ROLE) }}
                    </div>
                </div>
            </div>
        <hr>
        </div> -->
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <li class="{{ (Helper::uri2()=='home' ? 'active' : '') }}"><a href="{{ url('main/home?periode=').$runningMonth }}"><i class="icon-home2" style="color:#000"></i> <span>Beranda</span></a></li>

                    <!--  -->
                        <li class="navigation-header"><span>DATA</span> <i class="icon-menu" title="Utama"></i></li>

                        <li class="{{ (Helper::uri2()=='pldp' ? 'active' : '') }}">
                            <a href="{{ url('main/pldp?negara=__PILIH__&periode=').$runningMonth }}"><span>Penerimaan Layanan Deteni</span></a>
                        </li>

                        <li class="{{ (Helper::uri2()=='pldp_' ? 'active' : '') }}">
                            <a href="{{ url('main/pldp_?negara=__PILIH__&periode=').$runningMonth }}"><span>Penerimaan Layanan Pengungsi</span></a>
                        </li>

                        <li class="{{ (Helper::uri2()=='tupoksi') ? 'active' : '' }}">
                            <a href="{{ url('main/tupoksi?periode=').$runningMonth }}"><span>Tupoksi</span></a>
                        </li>

                        <li class="{{ ( Helper::uri2()=='tu') ? 'active' : '' }}">
                            <a href="#"><span>Tata Usaha</span></a>
                            <ul>
                                <li class="{{ (Helper::uri3()=='belanja') ? 'active' : '' }}">
                                    <a href="#"><span>Laporan Realisasi Anggaran dan Pendapatan</span></a>
                                    <ul>
                                        <li class="{{ (Helper::uri4()=='realisasi-belanja') ? 'active' : '' }}">
                                            <a href="{{ url('main/tu/belanja/realisasi-belanja?periode=').$runningMonth }}"></i> Laporan Realisasi Belanja</a>
                                        </li>
                                        <li class="{{ (Helper::uri4()=='realisasi-pendapatan') ? 'active' : '' }}">
                                            <a href="{{ url('main/tu/belanja/realisasi-pendapatan?periode=').$runningMonth }}"></i> Laporan Realisasi Pendapatan</a>
                                        </li>
                                        <!-- <li class="{{ (Helper::uri4()=='rm-pnbp') ? 'active' : '' }}">
                                            <a href="{{ url('main/tu/belanja/rm-pnbp?periode=').$runningMonth }}"></i> Rupiah Murni + PNBP</a>
                                        </li> -->
                                    </ul>
                                </li>

                                <!--  -->

                                <li class="{{ (Helper::uri3()=='ikpa') ? 'active' : '' }}">
                                    <a href="{{ url('main/tu/ikpa?periode=').$runningMonth }}"><span>Indikator Kinerja Pelaksanaan Anggaran (IKPA)</span></a>
                                </li>

                                <li class="{{ (Helper::uri3()=='kepegawaian') ? 'active' : '' }}">
                                    <a href="#"><span>Urusan Kepegawaian</span></a>
                                    <ul>
                                        <li class="{{ (Helper::uri4()=='bezetting') ? 'active' : '' }}">
                                            <a href="{{ url('main/tu/kepegawaian/bezetting?periode=').$runningMonth }}"></i> Laporan Bezetting Pegawai</a>
                                        </li>
                                        <li class="{{ (Helper::uri4()=='rekap') ? 'active' : '' }}">
                                            <a href="{{ url('main/tu/kepegawaian/rekap?periode=').$runningMonth }}"></i> Rekapitulasi Pegawai</a>
                                        </li>
                                        <li class="{{ (Helper::uri4()=='cuti') ? 'active' : '' }}">
                                            <a href="{{ url('main/tu/kepegawaian/cuti?periode=').$runningMonth }}"></i> Data Cuti Pegawai</a>
                                        </li>
                                        <li class="{{ (Helper::uri4()=='pembinaan') ? 'active' : '' }}">
                                            <a href="{{ url('main/tu/kepegawaian/pembinaan?periode=').$runningMonth }}"></i> Pembinaan Pegawai</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="{{ (Helper::uri3()=='umum') ? 'active' : '' }}">
                                    <a href="#"><span>Urusan Umum</span></a>
                                    <ul>
                                        <li class="{{ (Helper::uri4()=='persuratan') ? 'active' : '' }}">
                                            <a href="{{ url('main/tu/umum/persuratan?periode=').$runningMonth }}"></i> Tata Persuratan</a>
                                        </li>
                                        <li class="{{ (Helper::uri4()=='kendaraan') ? 'active' : '' }}">
                                            <a href="{{ url('main/tu/umum/kendaraan?periode=').$runningMonth }}"></i> Kendaraan Operasional</a>
                                        </li>
                                        <li class="{{ (Helper::uri4()=='sarpras') ? 'active' : '' }}">
                                            <a href="{{ url('main/tu/umum/sarpras?periode=').$runningMonth }}"></i> Sarana Dan Prasarana</a>
                                        </li>
                                        <li class="{{ (Helper::uri4()=='bangunan') ? 'active' : '' }}">
                                            <a href="{{ url('main/tu/umum/bangunan?periode=').$runningMonth }}"></i> Gedung Dan Bangunan</a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </li>

                        <hr>

                    <!--  -->
                    <li class="navigation-header"><span>GRAFIK</span> <i class="icon-menu" title="Utama"></i></li>

                    <li class="{{ (Helper::allUri(3, 2)=='grafik/pldp' ? 'active' : '') }}">
                        <a href="{{ url('main/grafik/pldp?periode=').$runningMonth }}"><span>Penerimaan Layanan Deteni</span></a>
                    </li>

                    <li class="{{ (Helper::allUri(3, 2)=='grafik/pldp_' ? 'active' : '') }}">
                        <a href="{{ url('main/grafik/pldp_?periode=').$runningMonth }}"><span>Penerimaan Layanan Pengungsi</span></a>
                    </li>

                    <li class="{{ (Helper::allUri(3, 2)=='grafik/tupoksi') ? 'active' : '' }}">
                        <a href="{{ url('main/grafik/tupoksi?periode=').$runningMonth }}"><span>Tupoksi</span></a>
                    </li>

                    <li class="{{ ( Helper::allUri(3, 2)=='grafik/tu') ? 'active' : '' }}">
                        <a href="#"><span>Tata Usaha</span></a>
                        <ul>
                            <li class="{{ (Helper::allUri(4, 2)=='grafik/tu/belanja') ? 'active' : '' }}">
                                <a href="#"><span>Laporan Realisasi Anggaran dan Pendapatan</span></a>
                                <ul>
                                    <li class="{{ (Helper::allUri(5, 2)=='grafik/tu/belanja/realisasi-belanja') ? 'active' : '' }}">
                                        <a href="{{ url('main/grafik/tu/belanja/realisasi-belanja?periode=').$runningMonth }}"></i> Laporan Realisasi Belanja</a>
                                    </li>
                                    <li class="{{ (Helper::allUri(5, 2)=='grafik/tu/belanja/realisasi-pendapatan') ? 'active' : '' }}">
                                        <a href="{{ url('main/grafik/tu/belanja/realisasi-pendapatan?periode=').$runningMonth }}"></i> Laporan Realisasi Pendapatan</a>
                                    </li>
                                    <!--<li class="{{ (Helper::allUri(5, 2)=='grafik/tu/belanja/rm-pnbp') ? 'active' : '' }}">-->
                                    <!--    <a href="{{ url('main/grafik/tu/belanja/rm-pnbp?periode=').$runningMonth }}"></i> Rupiah Murni + PNBP</a>-->
                                    <!--</li>-->
                                </ul>
                            </li>

                            <!--  -->

                            <li class="{{ (Helper::allUri(4, 2)=='grafik/tu/ikpa') ? 'active' : '' }}">
                                <a href="{{ url('main/grafik/tu/ikpa?periode=').$runningYear }}"><span>Indikator Kinerja Pelaksanaan Anggaran (IKPA)</span></a>
                            </li>

                            <li class="{{ (Helper::allUri(4, 2)=='grafik/tu/kepegawaian') ? 'active' : '' }}">
                                <a href="#"><span>Urusan Kepegawaian</span></a>
                                <ul>
                                    <li class="{{ (Helper::allUri(5, 2)=='grafik/tu/kepegawaian/bezetting') ? 'active' : '' }}">
                                        <a href="{{ url('main/grafik/tu/kepegawaian/bezetting?periode=').$runningMonth }}"></i> Laporan Bezetting Pegawai</a>
                                    </li>
                                    <li class="{{ (Helper::allUri(5, 2)=='grafik/tu/kepegawaian/rekap') ? 'active' : '' }}">
                                        <a href="{{ url('main/grafik/tu/kepegawaian/rekap?periode=').$runningMonth }}"></i> Rekapitulasi Pegawai</a>
                                    </li>
                                    <li class="{{ (Helper::allUri(5, 2)=='grafik/tu/kepegawaian/cuti') ? 'active' : '' }}">
                                        <a href="{{ url('main/grafik/tu/kepegawaian/cuti?periode=').$runningMonth }}"></i> Data Cuti Pegawai</a>
                                    </li>
                                    <li class="{{ (Helper::allUri(5, 2)=='grafik/tu/kepegawaian/pembinaan') ? 'active' : '' }}">
                                        <a href="{{ url('main/grafik/tu/kepegawaian/pembinaan?periode=').$runningMonth }}"></i> Pembinaan Pegawai</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="{{ (Helper::allUri(4, 2)=='grafik/tu/umum') ? 'active' : '' }}">
                                <a href="#"><span>Urusan Umum</span></a>
                                <ul>
                                    <li class="{{ (Helper::allUri(5, 2)=='grafik/tu/umum/persuratan') ? 'active' : '' }}">
                                        <a href="{{ url('main/grafik/tu/umum/persuratan?periode=').$runningMonth }}"></i> Tata Persuratan</a>
                                    </li>
                                    <li class="{{ (Helper::allUri(5, 2)=='grafik/tu/umum/kendaraan') ? 'active' : '' }}">
                                        <a href="{{ url('main/grafik/tu/umum/kendaraan?periode=').$runningMonth }}"></i> Kendaraan Operasional</a>
                                    </li>
                                    <li class="{{ (Helper::allUri(5, 2)=='grafik/tu/umum/sarpras') ? 'active' : '' }}">
                                        <a href="{{ url('main/grafik/tu/umum/sarpras?periode=').$runningMonth }}"></i> Sarana Dan Prasarana</a>
                                    </li>
                                    <li class="{{ (Helper::allUri(5, 2)=='grafik/tu/umum/bangunan') ? 'active' : '' }}">
                                        <a href="{{ url('main/grafik/tu/umum/bangunan?periode=').$runningMonth }}"></i> Gedung Dan Bangunan</a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </li>
                    
                    @if(Session("admin_session")->U_ROLE != "ROLE_USER")
                        <hr>
                        <li class="navigation-header"><span>ADMINISTRATOR</span> <i class="icon-menu" title="Utama"></i></li>

                        <li class="{{ (Helper::uri2()=='user' ? 'active' : '') }}">
                            <a href="{{ url('main/user') }}"><span>User Manager</span></a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>
