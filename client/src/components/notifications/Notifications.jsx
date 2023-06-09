import React, { useEffect, useState } from 'react'
import { Link } from 'react-router-dom';
import { useStateContext } from '../../contexts/ContextProvider';

const Notifications = () => {
  const { abilities, notifications } = useStateContext();
  const [notificationsHtml, setNotificationsHtml] = useState(null);

  useEffect(() => {
console.log(notifications)
    let filteredNotifications = notifications;

    if (abilities.includes('admin') && abilities.includes('approver')) {
      // if the user has both abilities, show notifications for both targets
      filteredNotifications = filteredNotifications.filter(notification => {
        return notification.target === 'admin' || notification.target === 'approver';
      });
    } else if (abilities.includes('admin')) {
      // if the user has admin ability, show only admin notifications
      filteredNotifications = filteredNotifications.filter(notification => notification.target === 'admin');
    } else if (abilities.includes('approver')) {
      // if the user has approver ability, show only approver notifications
      filteredNotifications = filteredNotifications.filter(notification => notification.target === 'approver');
    }
    const notificationsHtml = filteredNotifications.map(notification => (
      <li className="notification" key={notification.id}>
        <Link to={`/admin/dossiers/${notification.documentId}`}>
          {notification.message} <i className="fa-regular fa-folder-open"></i>
        </Link>
      </li>
    ));

    setNotificationsHtml(notificationsHtml);
  }, [abilities, notifications]);

  return (
 

    <ul className="notifications">
      {notificationsHtml?.length> 0 ? (notificationsHtml):(      <li className="notification" >vous nous avez pas de notification pour le moment</li>)}
    </ul>)
}

export default Notifications;
