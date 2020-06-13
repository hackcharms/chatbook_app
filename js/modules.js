function dayCalculator(date = '') {
    oldDate = new Date(date);
    // console.log(oldDate);
    now = new Date();
    diffrence = now - oldDate
    days = Math.floor(diffrence / (24 * 60 * 60 * 1000));
    // console.log('days:' + days);
    if (days == 0) {
        day = 'Today';
    } else if (days == 1) {
        day = 'Yesterday';
    } else {
        day = oldDate.toDateString();
    }
    return day;
}
// dayCalculator('4/27/2020 10:04:47')