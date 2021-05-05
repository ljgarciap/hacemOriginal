<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Video Tutoriales</li>
                </ol>
                <section class="container">
               <div class="container-fluid galeria-video-container">
        <div class="text-center pt-5">
        <h3 class="custom">Galeria de Video Tutoriales</h3>
        <p class="parrafo">Galeria de video tutoriales de la plataforma de HACEM</p>
        </div>
        <div class="row galeria-row">
            <div class="col-lg-3 col-md-6 col-sm-12 galeria-video">
                <video class="galeria-video-frame" width="100%" height="250" src="Videos/Video_Tutorial_Perfiles.mp4" controls></video>
                <label class="text-center form-control btn-warning custom-label">Video Tutorial de Perfiles</label>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 galeria-video">
                <video class="galeria-video-frame" width="100%" height="250" src="Videos/Video_Tutorial_Perfiles.mp4" controls></video>
                <label class="text-center form-control btn-warning custom-label">Video Tutorial de Perfiles</label>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 galeria-video">
                <video class="galeria-video-frame" width="100%" height="250" src="Videos/Video_Tutorial_Perfiles.mp4" controls></video>
                <label class="text-center form-control btn-warning custom-label">Video Tutorial de Perfiles</label>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 galeria-video">
                <video class="galeria-video-frame" width="100%" height="250" src="Videos/Video_Tutorial_Perfiles.mp4" controls></video>
                <label class="text-center form-control btn-warning custom-label">Video Tutorial de Perfiles</label>
            </div>
        </div>
        <div class="row galeria-row">
            <div class="col-lg-3 col-md-6 col-sm-12 galeria-video">
                <video class="galeria-video-frame" width="100%" height="250" src="Videos/Video_Tutorial_Perfiles.mp4" controls></video>
                <label class="text-center form-control btn-warning custom-label">Video Tutorial de Perfiles</label>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 galeria-video">
                <video class="galeria-video-frame" width="100%" height="250" src="Videos/Video_Tutorial_Perfiles.mp4" controls></video>
                <label class="text-center form-control btn-warning custom-label">Video Tutorial de Perfiles</label>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 galeria-video">
                <video class="galeria-video-frame" width="100%" height="250" src="Videos/Video_Tutorial_Perfiles.mp4" controls></video>
                <label class="text-center form-control btn-warning custom-label">Video Tutorial de Perfiles</label>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 galeria-video">
                <video class="galeria-video-frame" width="100%" height="250" src="Videos/Video_Tutorial_Perfiles.mp4" controls></video>
                <label class="text-center form-control btn-warning custom-label">Video Tutorial de Perfiles</label>
            </div>
        </div>
    </div>
 </section><br>
        </main>
</template>
<style>
   .custom {
   font-family: arial;
   font-size: 2em;
    }
    .custom-label{
        font-family: arial;
        font-size: 1em;
    }
     .parrafo {
   font-size:15px;
   font-family: Arial, Helvetica, sans-serif, "new times roman", lato;
   font-weight:bolder;
   line-height:30px;
   letter-spacing:5px;
   text-transform:capitalize;
   text-align:center;
   text-indent:30px;
  }
    .galeria-video-container {
        padding-top: 20px;
        font-family: Lato;
    }

    .galeria-video {
        padding: 10px;
    }

        .galeria-video:hover {
            background: #ced3da;
        }

    .galeria-video-frame {
        transition: width 1s, height 1s;
    }

        .galeria-video-frame:hover {
            height: 300px;
        }

    .galeria-row {
        margin-bottom: 10px;
    }
</style>