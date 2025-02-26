document.addEventListener("DOMContentLoaded", function () {
    let startTime, endTime, timeout;
    const reactionBox = document.querySelector("#reaction-box");

    reactionBox.addEventListener("click", function () {
        if (reactionBox.classList.contains("start")) {
            // Reset state
            reactionBox.classList.remove("start");
            reactionBox.classList.add("waiting");

            // Random delay between 2 and 5 seconds
            let randomDelay = Math.floor(Math.random() * 3000) + 2000;

            timeout = setTimeout(() => {
                startTime = new Date().getTime();
                reactionBox.classList.remove("waiting");
                reactionBox.classList.add("ready");
            }, randomDelay);
        } else if (reactionBox.classList.contains("ready")) {
            // Measure reaction time
            endTime = new Date().getTime();
            let reactionTime = endTime - startTime;
            reactionBox.classList.remove("ready");
            reactionBox.classList.add("result");
            reactionBox.dataset.reactionTime = reactionTime; // Store reaction time in data attribute
        } else {
            // Clicked too soon
            clearTimeout(timeout);
            reactionBox.classList.remove("waiting", "ready");
            reactionBox.classList.add("error");
        }
    });
});