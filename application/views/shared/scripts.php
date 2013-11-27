<!-- JS Includes -->
<script src="<?php echo $includes_dir;?>js/jquery-1.10.2.min.js"></script>
<script src="<?php echo $includes_dir;?>js/bootstrap.min.js"></script>
<script src="<?php echo $includes_dir;?>js/jquery.smartWizard-2.0.min.js"></script>
<script src="<?php echo $includes_dir;?>js/bootstrap-datepicker.js"></script>
<script src="<?php echo $includes_dir;?>js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo $includes_dir;?>js/jquery.numeric.js"></script>
<script src="<?php echo $includes_dir;?>js/base.js"></script>

<?php
    if(isset($menu)){
        if($menu === "kelas"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-kelas").addClass("active");
                });
            </script>
<?php   }else if($menu === "gurus"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-guru").addClass("active");
                });
            </script>
<?php   }else if($menu === "users"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-user").addClass("active");
                });
            </script>
<?php   }else if($menu === "user_groups"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-user_group").addClass("active");
                });
            </script>
<?php   }else if($menu === "group_privileges"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-group_privilege").addClass("active");
                });
            </script>
<?php   }else if($menu === "user_privileges"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-user_privilege").addClass("active");
                });
            </script>
<?php   }else if($menu === "privileges"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-privilege").addClass("active");
                });
            </script>
<?php   }else if($menu === "siswas"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-siswa").addClass("active");
                });
            </script>
<?php   }else if($menu === "jurusans"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-jurusan").addClass("active");
                });
            </script>
<?php   }else if($menu === "kurikulums"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-kurikulum").addClass("active");
                });
            </script>
<?php   }else if($menu === "tahun_ajarans"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-tahun_ajaran").addClass("active");
                });
            </script>
<?php   }else if($menu === "mata_pelajarans"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-mata_pelajaran").addClass("active");
                });
            </script>
<?php   }else if($menu === "kelas_bagians"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-kelas").addClass("active");
                });
            </script>
<?php   }else if($menu === "siswa_nilais"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-nilai").addClass("active");
                });
            </script>
<?php   }else if($menu === "absensis"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-absensi").addClass("active");
                });
            </script>
<?php   }else if($menu === "mata_pelajaran_persentases"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-persen_mp").addClass("active");
                });
            </script>
<?php   }else if($menu === "staffs"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-staff").addClass("active");
                });
            </script>
<?php   }else if($menu === "spps"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-spp").addClass("active");
                });
            </script>
<?php   }else if($menu === "guru_walis"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-guru").addClass("active");
                });
            </script>
<?php   }else if($menu === "guru_ijazahs"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-guru").addClass("active");
                });
            </script>
<?php   }else if($menu === "guru_mata_pelajarans"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-guru").addClass("active");
                });
            </script>
<?php   }else if($menu === "guru_kelas_matpels"){ ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#mainmenu ul li").removeClass("active");
                    $("#sidebar-guru").addClass("active");
                });
            </script>
 <?php       } ?>
 <?php   } ?>