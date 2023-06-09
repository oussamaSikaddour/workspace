import React from 'react';

const TimeSelector = ({ handleChange, inputs, type}) => {
  let value = "";
  let name = "";

  switch (type) {
    case "openTime":
      value = inputs.openTime;
      name = "openTime";
      break;
    case "closeTime":
        value = inputs.closeTime;
        name = "closeTime";
     break;
    case "startTime":
        value = inputs.startTime;
        name = "startTime";
    break;
    case "endTime":
        value = inputs.endTime;
        name = "endTime";
    break;
    default:
      value = "";
      name = "";
      break;
  }

  return (
    <div className="select__group">
      <select name={name} value={value || ""} onChange={handleChange}>
        <option value="">--- Choisir une heure ---</option>
        <option value="08:00:00">08:00</option>
        <option value="09:00:00">09:00</option>
        <option value="10:00:00">10:00</option>
        <option value="11:00:00">11:00</option>
        <option value="12:00:00">12:00</option>
        <option value="13:00:00">13:00</option>
        <option value="14:00:00">14:00</option>
        <option value="15:00:00">15:00</option>
        <option value="16:00:00">16:00</option>
        <option value="17:00:00">17:00</option>
        <option value="18:00:00">18:00</option>
        <option value="19:00:00">19:00</option>
        <option value="20:00:00">20:00</option>
        <option value="21:00:00">21:00</option>
        <option value="22:00:00">22:00</option>
        <option value="23:00:00">23:00</option>
        <option value="23:00:00">00:00</option>
      </select>
    </div>
  );
};

export default TimeSelector;
