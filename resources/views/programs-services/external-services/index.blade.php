@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row d-flex">
        <!-- Accordion Section -->
        <div class="col-lg-8 mb-4 mb-lg-0 d-flex flex-column">
            <h2 class="text-orange mb-3">EXTERNAL SERVICES</h2>
            <div class="accordion" id="servicesAccordion">
               <!-- First Item -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button btn-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            FINANCIAL ASSISTANCE FOR LOCAL GOVERNMENT UNITS (LGUs) ON THEIR CALAMITY PREVENTION / DAMAGED STRUCTURES
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#servicesAccordion">
                        <div class="accordion-body">
                            Details about this financial assistance program, including eligibility, process, and required documents.
                        </div>
                    </div>
                </div>

                <!-- Second Item -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button btn-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            FINANCIAL ASSISTANCE FROM THE OFFICE OF CIVIL DEFENSE — NATIONAL DISASTER RISK REDUCTION AND MANAGEMENT COUNCIL
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#servicesAccordion">
                        <div class="accordion-body">
                            Information about the assistance program provided by the Office of Civil Defense for disaster management.
                        </div>
                    </div>
                </div>


                <!-- Third Item -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button btn-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            NOMINATION FOR GAWAD KALAMIDAD AT SAKUNA LABANAN, SARILING GALING ANG KALIGTASAN (KALASAG)
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#servicesAccordion">
                        <div class="accordion-body">
                            Details on the nomination process for the Gawad Kalasag awards, recognizing disaster response excellence.
                        </div>
                    </div>
                </div>

                <!-- Fourth Item -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button btn-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            FINANCIAL ASSISTANCE FROM THE PROVINCIAL DRRM FUND TO OTHER LGUs DECLARED UNDER THE STATES OF CALAMITY
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#servicesAccordion">
                        <div class="accordion-body">
                            Explanation of how the Provincial DRRM fund is allocated to LGUs during states of calamity.
                        </div>
                    </div>
                </div>

                <!-- Fifth Item -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button btn-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            REQUEST FOR THE CONDUCT OF TRAININGS ON DRRM
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#servicesAccordion">
                        <div class="accordion-body">
                            Guidance on how to request and schedule disaster risk reduction and management training sessions.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Section for Disasters and Calamity Updates -->
        <div class="col-lg-4 d-flex flex-column">
            <div class="card w-100 mb- flex-grow-1">
                <div class="card-header bg-orange text-black">
                    DISASTERS AND CALAMITY UPDATES
                </div>
                <div class="card-body">
                    <p class="no-record">No Record!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
