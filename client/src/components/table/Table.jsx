import React, { memo, useMemo } from 'react';
import * as XLSX from 'xlsx';
import Tbody from './Tbody';
import Thead from './Thead';
import { useSortableTable } from './useSortableTable';

const Table = ({ ths, data,title=null, setSortedData ,excelFileName="table", activeRow=null}) => {
  const columns = Object.keys(data[0]).slice(1);
  const [handleSorting] = useSortableTable(data, setSortedData);

  const newData = useMemo(() => {

    const columnsFiltered = columns.filter(key => key !== 'actions');
    const filteredThs = ths.filter(value => value !== 'actions');

    return data.map((item) => {
      const newItem = {};
      columnsFiltered.forEach((column, index) => {
        newItem[filteredThs[index]] = item[column];
      });
      return newItem;
    });
  }, [data, ths, columns]);

  const handleExportToExcel = () => {
    // Convert the new data array to a worksheet using json_to_sheet
    const sheet = XLSX.utils.json_to_sheet(newData, { header: ths });

    // Create a new workbook and add the worksheet to it
    const book = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(book, sheet, 'Sheet1');

    // Save the workbook as an Excel file with the given filename
    XLSX.writeFile(book, `${excelFileName}.xlsx`);
  };


  return (
    <div className="table__container">
      <div className="table__header">
        <button className="button rounded" onClick={handleExportToExcel} >
          <i className="fa-solid fa-file-excel"></i>
        </button>
        <h2>{title}</h2>
      </div>
      <table>
        <Thead columns={columns} ths={ths} handleSorting={handleSorting} />
        <Tbody columns={columns} tableData={data}  activeRow={activeRow}/>
      </table>
    </div>
  );
};

export default memo(Table);
