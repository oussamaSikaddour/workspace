import React from 'react'


const StatusSelector = ({handleChange, inputs}) => {

  return (
    <div className="select__group">
      <select name="status" value={inputs.status||""} onChange={handleChange}>
        <option value="">--- Choisir etat ---</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>
    </div>
  )
}

export default StatusSelector;
