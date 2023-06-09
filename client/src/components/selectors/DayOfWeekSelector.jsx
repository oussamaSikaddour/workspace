import React from 'react';

const DayOfWeekSelector = ({ handleChange, inputs }) => {
  return (
    <div className="select__group">
      <select name="dayOfWeek" value={String(inputs.dayOfWeek) || ""} onChange={handleChange}>
        <option value="">--- Choisir un jour de la semaine ---</option>
        <option value="0">Samedi</option>
        <option value="1">Dimanche</option>
        <option value="2">Lundi</option>
        <option value="3">Mardi</option>
        <option value="4">Mercredi</option>
        <option value="5">Jeudi</option>
        <option value="6">Vendredi</option>
      </select>
    </div>
  );
};

export default DayOfWeekSelector;
