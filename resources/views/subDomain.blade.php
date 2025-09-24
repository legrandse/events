@extends('layouts.app')

@section('content')


<div class="container-xs">
 	
 	
	 	<div class="mt-3 py-2 mx-4 bg-white">
		 	<p class="text-center p-3 ">
		 	<span class="fs-1 fw-bold">Bravo !</span> <br><br>
		 	<span class="fs-2 ">La Fraternité vous remercie de votre visite sur cette page.</span><br>
		 	Nous espérons pouvoir bénéficier de votre aide dans l'élaboration de nos différents évènements qui ferons vivre notre village. <br>
		 	Pour commencer, nous vous invitons à cliquer ci-dessous : <br><br>
		 	<!--<a href="/register" class="btn btn-warning btn-lg"><span class="fs-2 ">Je m'inscris</span></a>-->
		 	<button type="button" class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#registerModal">
			  Suivant
			</button>

		 	
			</p>
		</div>
		
	       
		
		
		<!-- Modal -->
		<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    
		    <div class="modal-content">
		      <div class="modal-header">
		        <h6 class="modal-title mx-auto fs-5" id="exampleModalLabel"><span class="fw-bold">Connexion ou inscription</span></h6>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		       </div>
		      
		      <div class="modal-body">
			  <p class="fw-bold fs-4">Bienvenue sur Events</p>
		        @livewire('multi-step-form')

		      </div>
			</div>
		  </div>
		</div>
		
	
</div>








@endsection