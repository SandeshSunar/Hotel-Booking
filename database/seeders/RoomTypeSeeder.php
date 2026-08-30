// namespace Database\Seeders;

// use App\Models\RoomType;
// use App\Models\RoomTypeFacility;
// use Illuminate\Database\Seeder;

// class RoomTypeSeeder extends Seeder
// {
// public function run(): void
// {
// $types = [
// [
// 'name' => 'Single Room',
// 'slug' => 'single-room',
// 'category' => 'single',
// 'room_number' => '101',
// 'description' => 'A cozy single room designed for solo travelers who want comfort, privacy, and modern amenities in a
calm atmosphere.',
// 'short_description' => 'Perfect for solo travelers seeking comfort and privacy.',
// 'price_per_night' => 3500,
// 'discount_price' => null,
// 'room_size' => '18 sqm',
// 'bed_type' => '1 Single Bed',
// 'capacity_adults' => 1,
// 'capacity_children' => 0,
// 'total_rooms' => 5,
// 'available_rooms' => 5,
// 'facilities' => [
// ['name' => '1 Single Bed', 'icon' => 'bi-bed'],
// ['name' => 'Free Wi-Fi', 'icon' => 'bi-wifi'],
// ['name' => 'Air Conditioner', 'icon' => 'bi-snow2'],
// ['name' => 'Smart TV', 'icon' => 'bi-tv'],
// ['name' => 'Private Bathroom', 'icon' => 'bi-droplet-half'],
// ['name' => 'Free Parking', 'icon' => 'bi-p-square'],
// ],
// ],
// [
// 'name' => 'Double Room',
// 'slug' => 'double-room',
// 'category' => 'double',
// 'room_number' => '201',
// 'description' => 'An elegant double room ideal for couples or friends, offering spacious interiors, premium bedding,
and essential comforts for a relaxing stay.',
// 'short_description' => 'Spacious comfort for two guests with premium amenities.',
// 'price_per_night' => 5500,
// 'discount_price' => 4999,
// 'room_size' => '24 sqm',
// 'bed_type' => '1 Double Bed',
// 'capacity_adults' => 2,
// 'capacity_children' => 0,
// 'total_rooms' => 8,
// 'available_rooms' => 8,
// 'facilities' => [
// ['name' => 'Free Wi-Fi', 'icon' => 'bi-wifi'],
// ['name' => 'Air Conditioner', 'icon' => 'bi-snow2'],
// ['name' => 'Smart TV', 'icon' => 'bi-tv'],
// ['name' => 'Breakfast Included', 'icon' => 'bi-cup-hot'],
// ['name' => 'Private Bathroom', 'icon' => 'bi-droplet-half'],
// ],
// ],
// [
// 'name' => 'Family Room',
// 'slug' => 'family-room',
// 'category' => 'family',
// 'room_number' => '301',
// 'description' => 'A spacious family room built for groups, with generous space for adults and children, thoughtful
amenities, and a warm welcoming layout.',
// 'short_description' => 'Spacious stay for families with room for everyone.',
// 'price_per_night' => 8500,
// 'discount_price' => null,
// 'room_size' => '36 sqm',
// 'bed_type' => '1 King + 2 Single Beds',
// 'capacity_adults' => 4,
// 'capacity_children' => 2,
// 'total_rooms' => 4,
// 'available_rooms' => 4,
// 'facilities' => [
// ['name' => 'Free Wi-Fi', 'icon' => 'bi-wifi'],
// ['name' => 'Smart TV', 'icon' => 'bi-tv'],
// ['name' => 'Breakfast Included', 'icon' => 'bi-cup-hot'],
// ['name' => 'Private Bathroom', 'icon' => 'bi-droplet-half'],
// ],
// ],
// ];

// foreach ($types as $data) {
// $facilities = $data['facilities'];
// unset($data['facilities']);

// $roomType = RoomType::updateOrCreate(
// ['slug' => $data['slug']],
// $data
// );

// if ($roomType->facilities()->count() === 0) {
// foreach ($facilities as $facility) {
// RoomTypeFacility::create([
// 'room_type_id' => $roomType->id,
// 'name' => $facility['name'],
// 'icon' => $facility['icon'],
// ]);
// }
// }
// }
// }
// }