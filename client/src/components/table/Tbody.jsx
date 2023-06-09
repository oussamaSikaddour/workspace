import React, { memo, createRef } from 'react';
import moment from 'moment/moment';
import { daysOfWeek } from '../../util/util';

const Tbody = ({ tableData, columns, activeRow = null }) => {
  const rowRefs = tableData.map(() => createRef());

  const formatData = (column, data) => {
    if (column === 'dayOfWeek') {
  
      return daysOfWeek[data];
    }
    if (column.includes('At') || column.includes('Date') || column.includes('_at') || column.includes('days')) {
      return moment(data).format('YYYY-MM-DD');
    }
    if (column.includes('Time')) {
      const duration = moment.duration(data);
      return moment.utc(duration.asMilliseconds()).format('HH:mm');
    }
    return data;
  };

  return (
    <tbody>
      {tableData.map((data, rowIndex) => (
        <tr key={data.id} ref={rowRefs[rowIndex]} className={activeRow === data.id ? 'active' : ''}>
          {columns.map((column, columnIndex) => {
            const tData = data[column] === 0 ? 0 : data[column] || '——';
            const formattedData = formatData(column, tData);
            return <td className="table__td" key={columnIndex}>{formattedData}</td>;
          })}
        </tr>
      ))}
    </tbody>
  );
};

export default memo(Tbody);
