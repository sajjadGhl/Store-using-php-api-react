// Components
import Loading from '../Loading/Loading';

// Styles
import styles from './Sidebar.module.css';

const Sidebar = ({
	categories: { categories, setCategories },
	price: {
		value: { min: minPrice, max: maxPrice },
		set: setPrice,
	},
	name: { searchName, setSearchName },
	setReRender,
}) => {
	const price = { min: minPrice, max: maxPrice };

	const toggleCategoryStatus = (id) => {
		setCategories(
			categories.map((category) => {
				if (category.id === id) category.shown = !category.shown;
				return category;
			})
		);
	};

	return (
		<div className={styles.container}>
			<div className={styles.searchName}>
				<h3>جستجوی نام</h3>
				<input
					type="text"
					placeholder="جستجو بر اساس نام"
					value={searchName}
					onChange={(e) => setSearchName(e.target.value)}
				/>
			</div>
			<div className={styles.categories}>
				<h3>دسته بندی</h3>
				<div className={styles.categories_items}>
					{categories ? (
						categories.map((category) => (
							<div className={styles.category_item} key={category.id}>
								<label htmlFor={`category_${category.id}`}>{category.title}</label>
								<input
									type="checkbox"
									checked={category.shown}
									id={`category_${category.id}`}
									name={`category_${category.id}`}
									onChange={(e) => toggleCategoryStatus(category.id)}
								/>
							</div>
						))
					) : (
						<Loading />
					)}
				</div>
			</div>

			<div className={styles.price}>
				<label>تعیین قیمت</label>
				<div>
					<input
						type="text"
						placeholder="کمترین قیمت"
						value={(+price.min).toLocaleString()}
						onChange={(e) =>
							setPrice((price) => ({
								...price,
								min: e.target.value.replaceAll(',', ''),
							}))
						}
					/>
					<input
						type="text"
						placeholder="بیشترین قیمت"
						value={(+price.max).toLocaleString()}
						onChange={(e) =>
							setPrice((price) => ({
								...price,
								max: e.target.value.replaceAll(',', ''),
							}))
						}
					/>
				</div>
			</div>

			<button className={styles.btn} onClick={() => setReRender(true)}>
				اعمال تغییرات
			</button>
		</div>
	);
};

export default Sidebar;
