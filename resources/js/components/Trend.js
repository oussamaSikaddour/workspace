
import {toggleInertForAllExceptOpenedElement} from '../traits/Inert'
import {setAriaAttributes} from '../traits/Aria'
const toggleTrend = (trend,closeTrend)=> {
  const isOpen = trend.classList.contains("open");
   setAriaAttributes(!isOpen, isOpen ? "0" : "-1",trend);
    if (isOpen) {
      trend.classList.remove("open");
      toggleInertForAllExceptOpenedElement(trend,"open")
      closeTrend.focus()
    } else {
      trend.classList.add("open");
      toggleInertForAllExceptOpenedElement(trend,"open")
    }
  }



 const Trend = ()=>{
  const openTrend = document.querySelector(".trend__opener");
  const closeTrend = document.querySelector(".trend__closer");
  const trend = document.querySelector(".trend");

  if (trend){
    openTrend.addEventListener("click", ()=>toggleTrend(trend,closeTrend));
    closeTrend.addEventListener("click", ()=>toggleTrend(trend,closeTrend));
    }
}

export default Trend;
