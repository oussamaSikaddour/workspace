export const inView = (element, visibilityPercentage, callback, props = {}) => {
  if (!element) {
    return;
  }

  const observerOptions = {
    threshold: visibilityPercentage / 100,
  };



  const observer = new IntersectionObserver((entries)=>{
    callback(entries[0]?.isIntersecting,props)
  }, observerOptions);
  observer.observe(element);

};
export const infiniteScroll = (lastElement, callback, props = {}) => {
  if (!lastElement) {
    return;
  }
  const observerOptions = {
   rootMargin:"50px"
  };
  const observer = new IntersectionObserver((entries)=>{

  callback(entries[0].isIntersecting,{...props,observer,lastElement})
  }, observerOptions);
  observer.observe(lastElement);

  return () => {
    observer.disconnect();
  };

};







