<?php
require_once __DIR__ . '/includes/template/header.php';

?>

<div class="animation-holder">
    <canvas id="confetti-canvas"></canvas>
</div>

<div class="lot-order-animation-holder d-none" id="lot-order-animation-holder">
    <div class="anim-holder-inner">
        <span class="blink-animation anim-text-area" id="anim-text-area">1ኛ ዕጣ</span>
    </div>
</div>

<div class="container-fluid p-0">
    <div class="abay-logo">
        <img width="130" src="./assets/img/abay.png" alt="">
    </div>

    <div class="page-header w-100"></div>

    <div class="page-body">
        <div class="d-flex flex-column h-100">
            <div class="odometer-container flex-1-5">
                <div class="row h-100">
                    <div class="col-12 col-lg-8 d-flex flex-column justify-content-center align-items-center py-5">
                        <div class="mt-4">
                            <div class="odometer m-2" id="lot-1">0</div>
                            <div class="odometer m-2" id="lot-2">0</div>
                            <div class="odometer m-2" id="lot-3">0</div>
                            <div class="odometer m-2" id="lot-4">0</div>
                            <div class="odometer m-2" id="lot-5">0</div>
                            <div class="odometer m-2" id="lot-6">0</div>
                            <div class="odometer m-2" id="lot-7">0</div>
                            <div class="odometer m-2" id="lot-8">0</div>
                        </div>

                        <div class="pt-4">
                            <div id="draw-btn-area">
                                <div class="bnt-draw-lottery" id="bnt-draw-lottery">አውጣ</div>
                            </div>

                            <div id="draw-progress-area" class="d-none">
                                <img class="rounded-circle img-progress" src="./assets/img/draw-progress.gif" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="winners-container col-12 col-lg d-flex flex-column justify-content-center align-items-center  border-start m-3">
                        <div class="d-flex text-white">
                            <span class="lottery-round">
                                <span class="lottery-round-number">6</span><sup>ኛ</sup>
                                <span class="lottery-round-text">ዙር</span>
                            </span>
                        </div>

                        <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Show Winners
                        </button>
                    </div>
                </div>

            </div>

            <div class="gift-container flex--1 d--flex justify--content-center align--items-center">
                <div class="row px-5 py-3">
                    <div class="col-6">
                        <img class="img-fluid" src="./assets/img/car.jpg" alt="">
                    </div>
                    <div class="col-6  d-flex justify-content-center  align-items-center">
                        <img class="img-fluid" src="./assets/img/gifts.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-footer d-flex flex--column align--iitems-center justify-content-center text-white">
        <img class="img-fluid" src="./assets/img/slogan.jpg" alt="">
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Winners List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="winners-list pe-3">
                    <li class="border-bottom pb-1">
                        <strong class="fs-4 me-2">1<sup>ኛ</sup></strong>
                        <span class="fs-6">
                            <span id="lot-1st-1" class="lottery-num rounded-4 px-2">00000000</span>
                        </span>
                    </li>

                    <li class="border-bottom mt-3 pb-2">
                        <strong class="fs-4 me-2">2<sup>ኛ</sup></strong>
                        <span class="fs-6">
                            <span id="lot-2nd-1" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-2nd-2" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-2nd-3" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-2nd-4" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-2nd-5" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-2nd-6" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-2nd-7" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-2nd-8" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-2nd-9" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-2nd-10" class="lottery-num rounded-4 px-2">00000000</span>
                        </span>
                    </li>

                    <li class="border-bottom mt-3 pb-2">
                        <strong class="fs-4 me-2">3<sup>ኛ</sup></strong>
                        <span class="fs-6">
                            <span id="lot-3rd-1" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-3rd-2" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-3rd-3" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-3rd-4" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-3rd-5" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-3rd-6" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-3rd-7" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-3rd-8" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-3rd-9" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-3rd-10" class="lottery-num rounded-4 px-2">00000000</span>
                        </span>
                    </li>

                    <li class="border-bottom mt-3 pb-2">
                        <strong class="fs-4 me-2">4<sup>ኛ</sup></strong>
                        <span class="fs-6">
                            <span id="lot-4th-1" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-4th-2" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-4th-3" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-4th-4" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-4th-5" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-4th-6" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-4th-7" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-4th-8" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-4th-9" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-4th-10" class="lottery-num rounded-4 px-2">00000000</span>
                        </span>
                    </li>

                    <li class="mt-3 pb-2">
                        <strong class="fs-4 me-2">5<sup>ኛ</sup></strong>
                        <span class="fs-6">
                            <span id="lot-5th-1" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-5th-2" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-5th-3" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-5th-4" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-5th-5" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-5th-6" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-5th-7" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-5th-8" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-5th-9" class="lottery-num rounded-4 px-2">00000000</span>
                            <span id="lot-5th-10" class="lottery-num rounded-4 px-2">00000000</span>
                        </span>
                    </li>

                </ul>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="./winners.php" target="_blank" type="button" class="btn btn-primary">Winners</a>
                </div>
            </div>
        </div>
    </div>


    <?php require_once  __DIR__ . '/includes/template/footer.php'; ?>