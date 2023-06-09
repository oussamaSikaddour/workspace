
export const useSortableTable = (data ,setSortedData) => {

 const handleSorting = (sortField, sortOrder) => {
  if (sortField) {
   const sorted = [...data].sort((a, b) => {
    if (a[sortField] === null) return 1;
    if (b[sortField] === null) return -1;
    if (a[sortField] === null && b[sortField] === null) return 0;
    return (
     a[sortField].toString().localeCompare(b[sortField].toString(), "fr", {
      numeric: true,
     }) * (sortOrder === "asc" ? 1 : -1)
    );
   });
   setSortedData(sorted);
  }
 };

 return [ handleSorting];
};



