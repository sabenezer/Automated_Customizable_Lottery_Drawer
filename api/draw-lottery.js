"use strict";

$(document).ready(function () {
  function toggleProgress() {
    $("#draw-progress-area").toggleClass("d-none");
    $("#draw-btn-area").toggleClass("d-none");
  }

  function reset() {
    $("#lot-1").html(0);
    $("#lot-2").html(0);
    $("#lot-3").html(0);
    $("#lot-4").html(0);
    $("#lot-5").html(0);
    $("#lot-6").html(0);
    $("#lot-7").html(0);
    $("#lot-8").html(0);
  }

  const delay = (delayInms) => {
    return new Promise((resolve) => setTimeout(resolve, delayInms));
  };

  async function loop(lot_id, org_value, t_delay) {
    let go = true;

    async function start() {
      for (let i = 0; i <= 9; i++) {
        if (!go) break;

        $(`#${lot_id}`).html(i);
        await delay(50);
      }

      if (go) start();
      else $(`#${lot_id}`).html(org_value);
    }

    start();
    setTimeout(async () => {
      go = false;
    }, t_delay);
  }

  function paintAllWinners(winners) {
    for (let prop in winners) {
      if (Object.keys(winners[prop]).length) {
        for (let i = 0; i < Object.keys(winners[prop]).length; i++) {
          let html_span_id = `lot-${winners[prop][i].draw_round}-${i + 1}`;
          html_span_id = html_span_id.trim();

          if ($(`#${html_span_id}`).length)
            $(`#${html_span_id}`).html(winners[prop][i].coupon);
        }
      }
    }
  }

  $("#bnt-draw-lottery").on("click", function () {
    reset();
    toggleProgress();

    var apiUrl = `./api/php/draw-lottery.php`;
    var AXIOS_COMMON_CONFIGS = {
      timeout: 600000,
      validateStatus: function (status) {
        if (status === 200) return true;

        toggleProgress();
        return false;
      },
    };

    axios
      .get(apiUrl, {
        ...AXIOS_COMMON_CONFIGS,
        params: {
          draw: "abay-lottery",
        },
      })
      .then(async function (response) {
        const coupon = response.data.current_winner.coupon.toString();
        const draw_round = response.data.current_winner.draw_round.toString();
        const draw_count = response.data.current_winner.draw_count.toString();
        const all_winners = response.data.all_winners;

        console.log(coupon);
        console.log(draw_round);

        loop("lot-8", coupon[7], 1000);
        loop("lot-7", coupon[6], 2000);
        loop("lot-6", coupon[5], 3000);
        loop("lot-5", coupon[4], 3500);
        loop("lot-4", coupon[3], 4000);
        loop("lot-3", coupon[2], 4500);
        loop("lot-2", coupon[1], 5000);
        loop("lot-1", coupon[0], 5500);

        setTimeout(() => {
          paintAllWinners(all_winners);
          startConfetti();
          toggleProgress();

          $("#lot-order-animation-holder").removeClass("d-none");
          $("#anim-text-area").html(draw_round + " : " + draw_count);

          setTimeout(() => {
            stopConfetti();
            $("#lot-order-animation-holder").addClass("d-none");
            $("#anim-text-area").html("");
          }, 3000);
        }, 6000);
      })
      .catch(function (error) {
        if (!error.response) {
          console.log(error);
          toggleProgress();
          alert("Couldn't connect to server.");
        } else {
          console.log(error.response.data);
          alert(error.response.data);
        }
      });
  });
});
