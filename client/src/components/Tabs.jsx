import React, { useState } from 'react';
import ReactDOMServer from 'react-dom/server';

const Tabs = ({ tabs }) => {
  const [activeTab, setActiveTab] = useState(0);

  const handleClick = (tabIndex) => {
    setActiveTab(tabIndex);
  };

  return (
    <div className="tabs__container">
      <ul className="tab__links">
        {tabs?.map((tab, index) => (
          <li
            key={index}
            className={`tab__link ${index === activeTab ? 'active' : ''}`}
            onClick={() => handleClick(index)}
          >
            {tab.label}
          </li>
        ))}
      </ul>
      <div className="tabs">
        {tabs?.map((tab, index) => (
          <div
            key={index}
            className={`tab ${index === activeTab ? 'active' : ''}`}
          >
           {index === activeTab && tab.content}

          </div>
        ))}
      </div>
    </div>
  );
};

export default Tabs;
