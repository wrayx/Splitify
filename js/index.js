const progressBars = document.querySelectorAll(".progress-bar");
for (let i = 0; i < progressBars.length; i++) {
    let idArr = progressBars[i].id.split("-");
    let id = idArr.pop();
    let percentage = idArr.pop();
    progressBars[i].style.width = `${percentage.toString()}%`;
    // progressBars[i].animate([
    //     {width: 0%},
    //     {width: `${percentage}`%}
    // ], 0.8s);
    console.log(progressBars[i].animate([
        // keyframes
        {width: '0%'},
        {width: `${percentage}%`}
    ], {
        // timing options
        duration: 1000
    }));
}