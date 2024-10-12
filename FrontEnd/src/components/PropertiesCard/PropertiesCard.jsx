// styles
import styles from './PropertiesCard.module.css';

const PropertiesCard = ({title, description}) => {
	return <div className={styles.container}>
        <h4>{title}</h4>
        <p>{description}</p>
    </div>;
};

export default PropertiesCard;
