class Counter {

    static s = [1000,60,60,24]; 
    constructor(timesClass, dateEvent){
        this.durationBeforeEvent = new Date(dateEvent) - new Date();
        this.timerElements = Array.from(document.querySelectorAll(timesClass)).reverse();
    }

    activation(){
        const vset = (e,t,c) => {
            const m = c ? t % c : t;
            e.setAttribute('b', m < 10 ? '0' + m : m);
            e.classList.remove('ping');
            setTimeout(() => e.classList.add('ping'), 10);
            return m;
        };
        const calc = (t,i=0,b=0) => {
            if (!Counter.s[i]) return;
            t = opti(t,Counter.s[i]);
            if (vset(this.timerElements[i],t,Counter.s[i+1])==Counter.s[i+1]-1 || b) calc(t,i+1,b);
        }
        
        const count = (b=0) => (this.durationBeforeEvent -= 1000) && calc(this.durationBeforeEvent,0,b);
        const opti = (v,n) => (v - (v % n)) / n;
        
        setTimeout(() => !count(1) && setInterval(count, 1000), this.durationBeforeEvent % 1000);
    }
}

let counterFirstRound = new Counter('.counter-first-round', '2022-04-10T20:00:00'); 
counterFirstRound.activation();


let counterSecondRound = new Counter('.counter-second-round', '2022-04-24T20:00:00'); 
counterSecondRound.activation(); 