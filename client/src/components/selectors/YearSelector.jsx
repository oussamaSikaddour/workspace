import React from 'react'


const YearSelector = ({handleChange, inputs}) => {

  return (
    <div className="select__group">
      <select name="year" value={inputs.year||""} onChange={handleChange}>
        <option value="">--- Choisir une année ---</option>
        <option value="2023">2023</option>
        <option value="2024">2024</option>
        <option value="2025">2025</option>
        <option value="2026">2026</option>
        <option value="2027">2027</option>
        <option value="2028">2028</option>
        <option value="2029">2029</option>
        <option value="2030">2030</option>
      </select>
    </div>
  )
}

export default YearSelector;
