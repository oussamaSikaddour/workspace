import { memo, useCallback, useState } from "react";

const Thead = ({ths, columns, handleSorting }) => {
  const [sortField, setSortField] = useState("");
  const [order, setOrder] = useState("asc");
  
  const handleSortingChange = useCallback((column) => {
    const sortOrder = column === sortField ? (order === "asc" ? "desc" : "asc") : "asc";
    setSortField(column);
    setOrder(sortOrder);
    handleSorting(column, sortOrder);
  }, [handleSorting, order, sortField]);
 
  return (
    <thead>
      <tr>
        {columns.map((column, columnIndex) => (
          <th
            key={columnIndex}
            className={`table__th ${sortField === column ? (order === "asc" ? "up" : "down") : ""}`}
            onClick={() => handleSortingChange(column)}
          >
            {ths[columnIndex]}
          </th>
        ))}
      </tr>
    </thead>
  );
};

export default memo(Thead);