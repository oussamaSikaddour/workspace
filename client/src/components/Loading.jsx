import React from 'react'

const Loading = (variant = "") => {
  return (
    <div className={ variant ? "loader "+ variant :"loader"}>
      <div className="loader__circle"></div>
      <div className="loader__circle"></div>
    </div>
  )
}

export default Loading