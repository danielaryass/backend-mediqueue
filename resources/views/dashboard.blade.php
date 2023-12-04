@extends('layouts.app')
@section('title' , 'Dashboard')
@section('content')
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4>With controls</h4>
            <p>A carousel with previous and next control.</p>
          </div>
          <div class="card-body">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="./assets/compiled/jpg/banana.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="./assets/compiled/jpg/bg-mountain.jpg" class="d-block w-100" alt="...">
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </a>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4>Crossfade Transition</h4>
            <p>A carousel crossfade transition.</p>
          </div>
          <div class="card-body">
            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carouselfade">
              <ol class="carousel-indicators">
                <li data-bs-target="#carouselExampleFade" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carouselExampleFade" data-bs-slide-to="1"></li>
                <li data-bs-target="#carouselExampleFade" data-bs-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="./assets/compiled/png/1.png" class="d-block w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                  </div>
                </div>
                <div class="carousel-item">
                  <img src="./assets/compiled/png/2.png" class="d-block w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                  </div>
                </div>
                <div class="carousel-item">
                  <img src="./assets/compiled/png/3.png" class="d-block w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                  </div>
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </a>
            </div>
          </div>
        </div>
      </div>
@endsection