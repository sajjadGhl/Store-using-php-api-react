// styles
import styles from './ShowProfile.module.css';

// API
import { getProfile } from '../../services/api';

// Libraries
import { useEffect, useState } from 'react';

const ShowProfile = () => {
	const [data, setData] = useState({});

	useEffect(() => {
		const fetch = async () => {
			setData(await getProfile());
		};
		fetch();
	}, []);

	return (
		<div className={styles.container}>
			<div>
				<label htmlFor="">ایمیل: </label>
				<p>{data.email}</p>
			</div>

			<div>
				<label htmlFor="">نام: </label>
				<p>
					{data.first_name} {data.last_name}
				</p>
			</div>

			<div>
				<label htmlFor="">شماره: </label>
				<p>{data.phone}</p>
			</div>
		</div>
	);
};

export default ShowProfile;
