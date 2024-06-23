

const despatchCustomEvent= (eventName,data={})=>{
    const setLocaleEvent = new CustomEvent(eventName, {
        detail: {
            data
        }
    });
    document.dispatchEvent(setLocaleEvent);
    }
    
export default despatchCustomEvent;