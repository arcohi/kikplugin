document.addEventListener("DOMContentLoaded", function () {
    let startTime, endTime, timeout;
    const reactionBox = document.querySelector("#reaction-box");

    // function checkState(clickedTarget) 

    // reactionBox.addEventListener("click", function (event) {
    //     console.log('some click');
    // })

    reactionBox.addEventListener("click", function (event) {
        let clickedTarget = event.currentTarget;
        // console.log("clickedTarget");

        if (clickedTarget.classList.contains("start")) {
            console.log('clicked start');

            clickedTarget.classList.remove("start");
            clickedTarget.classList.add("wait");
            reactionBox.textContent = 'Wait';

            let randomDelay = Math.floor(Math.random() * 3000) + 2000;

            timeout = setTimeout(() => {
                startTime = new Date().getTime();
                reactionBox.classList.remove("wait");
                reactionBox.classList.add("ready");
                reactionBox.textContent = 'Now!';
            }, randomDelay);

            // return "start";
        } else if (clickedTarget.classList.contains("wait")) {
            console.log('clicked wait');

            // return "wait";
            clickedTarget.classList.remove("wait");
            clickedTarget.classList.add("error");
            reactionBox.textContent = 'Too fast';
            // too fast try again
        } else if (clickedTarget.classList.contains("ready")) {
            console.log('clicked ready');
            // reactionBox.textContent = 'Wait';
            // console.log("clickedTarget.classList.contains("ready")");
            // console.log(clickedTarget.classList.contains("ready"));
            // return "ready";

            endTime = new Date().getTime();
            let reactionTime = endTime - startTime;

            reactionBox.classList.remove("ready");
            reactionBox.classList.add("result");
            reactionBox.dataset.reactionTime = reactionTime;
            reactionBox.textContent = reactionTime;
            // end timer
        } else if (clickedTarget.classList.contains("result")) {
            console.log('clicked result');

            // console.log("clickedTarget.classList.contains("result")");
            // console.log(clickedTarget.classList.contains("result"));
            // return "result";

            clickedTarget.classList.remove("result");
            clickedTarget.classList.add("start");
            reactionBox.textContent = 'Start';

        } else if (clickedTarget.classList.contains("error")) {
            console.log('clicked error');
            // console.log("clickedTarget.classList.contains("error")");
            // console.log(clickedTarget.classList.contains("error"));
            clickedTarget.classList.remove("error");
            clickedTarget.classList.add("start");
            reactionBox.textContent = 'Start';
        }




        // checkState(event.currentTarget);
        // checkState(clickedTarget)
        // if (reactionBox.classList.contains("start")) {
        //     // Reset state
        //     reactionBox.classList.remove("start");
        //     reactionBox.classList.add("waiting");

        //     // Random delay between 2 and 5 seconds
        //     let randomDelay = Math.floor(Math.random() * 3000) + 2000;

        //     timeout = setTimeout(() => {
        //         startTime = new Date().getTime();
        //         reactionBox.classList.remove("waiting");
        //         reactionBox.classList.add("ready");
        //     }, randomDelay);
        // } else if (reactionBox.classList.contains("ready")) {
        //     // Measure reaction time
        //     endTime = new Date().getTime();
        //     let reactionTime = endTime - startTime;
        //     reactionBox.classList.remove("ready");
        //     reactionBox.classList.add("result");
        //     reactionBox.dataset.reactionTime = reactionTime; // Store reaction time in data attribute
        // } else {
        //     // Clicked too soon
        //     clearTimeout(timeout);
        //     reactionBox.classList.remove("waiting", "ready");
        //     reactionBox.classList.add("error");
        // }
    });

    // kazda klasa bedzie musiala miec swoj kolor i tekst
    // [ click to start ] *clisk* [ wait x seconds]  -start counting time[ click fast ] -click- [ result in seconds ]
});