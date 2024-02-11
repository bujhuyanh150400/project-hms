<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminPanelSeeder extends Seeder
{
    /**
     *  php artisan db:seed --class=AdminPanelSeeder
     */
    public function run(): void
    {
        // Clinic 
        DB::table('clinic')->insert([
            'id' => 24021008224354,
            'name' => 'Cơ sở Phạm Tuấn Tài',
            'province' => '01',
            'district' => '005',
            'ward' => '00167',
            'address' => 'Số 71, Phạm Tuấn Tài',
            'logo' => null,
            'description' => '<h2><strong>CHÚNG TÔI LÀ AI?</strong></h2><p>Thành lập tháng 11/2011, cho đến nay 2Vet đã trở thành hệ thống thú y thuộc TOP 3 uy tín nhất tại Việt Nam, với 15 chi nhánh cùng hơn 100 cán bộ y bác sĩ trên khắp 3 miền Tổ quốc. Đến nay chúng tôi đã có trên 200000 khách hàng, 55 đối tác chiến lược và 60 nhà cung ứng tin cậy. Hệ sinh thái của 2Vet bao gồm 5 lĩnh vực: Bệnh viện thú cưng (2Vet Hospital), Phụ kiện và thức ăn thú cưng (2Vet Petshop), Làm đẹp và khách sạn thú cưng (2Vet Grooming), Bệnh viện online (2Vet Online), Đào tạo và chuyển giao công nghệ (2Vet Education). Đến với 2Vet, khách hàng sẽ được đáp ứng dịch vụ thú cưng toàn diện với chất lượng cao.</p><p>Ngay từ những ngày đầu thành lập, 2Vet đã định hình trở thành một trong những hệ thống thú cưng hàng đầu tại Việt Nam với hình ảnh: Uy tín – Chất lượng – Tiên phong. Điểm mạnh nhất của 2Vet là đội ngũ nhân sự tài năng, năng động, nhiệt huyết với nghề, dựa trên giá trị cốt lõi “con người đi trước”, nơi nhân sự được làm việc trong môi trường tôn trọng, chuyên nghiệp và đầy lòng nhân ái.</p><p>2Vet – Thú Cưng Là Thượng Đế</p><p>Office: Số 71, Phạm Tuấn Tài, Cầu Giấy</p>',
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => 15042000,
            'created_by' => 15042000,
        ]);
        // Specialties
        DB::table('specialties')->insert([
            'id' => 24021016293164,
            'name' => 'Khoa Da liễu',
            'logo' => null,
            'description' => '<p>Chẩn đoán, điều trị, dự phòng và phục hồi chức năng các bệnh lý thuộc chuyên ngành Da liễu (da và các phần phụ của da gồm lông, tóc, móng, tuyến mồ hôi) cho thú cưng.</p>',
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => 15042000,
            'created_by' => 15042000,
        ]);
        DB::table('specialties')->insert([
            'id' => 24021016284430,
            'name' => 'Khoa Tiêu hóa gan mật',
            'logo' => null,
            'description' => '<p>Chẩn đoán và tiếp nhận điều trị nội trú, ngoại trú với bệnh liên quan đến tiêu hóa, gan, mật và tụy gồm điều trị phẫu thuật và không phẫu thuật.</p>',
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => 15042000,
            'created_by' => 15042000,
        ]);
        DB::table('specialties')->insert([
            'id' => 24021016300641,
            'name' => 'Khoa chẩn đoán hình ảnh',
            'logo' => null,
            'description' => '<p>Chuyên thực hiện các chẩn đoán như: Siêu âm, X quang, Chụp CT,.... Với máy móc hiện đại như máy siêu âm 4D Mindray Ventus 7. Máy chụp Xquang kỹ thuật số.&nbsp;</p>',
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => 15042000,
            'created_by' => 15042000,
        ]);
        DB::table('specialties')->insert([
            'id' => 24021016304348,
            'name' => 'Khoa Sản',
            'logo' => null,
            'description' => '<p><strong>Khoa Sản </strong>Cung cấp giải pháp theo dõi, chăm sóc sức khỏe toàn diện và an toàn cho thú cưng trong suốt chu kỳ thai sản, nhằm mang đến trạng thái sức khỏe tốt nhất cho cả mẹ và con.</p>',
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => 15042000,
            'created_by' => 15042000,
        ]);
        DB::table('specialties')->insert([
            'id' => 24021016310692,
            'name' => 'Khoa Mắt',
            'logo' => null,
            'description' => '<p><strong>Khoa Mắt </strong>Khám và điều trị toàn diện các bệnh lý về mắt cho thú cưng với đội ngũ bác sĩ giàu kinh nghiệm, chuyên môn sâu trong điều trị bằng nội khoa và ngoại khoa.</p>',
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => 15042000,
            'created_by' => 15042000,
        ]);
        DB::table('specialties')->insert([
            'id' => 24021016313255,
            'name' => 'Khoa Cơ Xương Khớp',
            'logo' => null,
            'description' => '<p>Khám, chẩn đoán, điều trị và phát hiện sớm các dị tật xương, khớp, cột sống; ngăn ngừa và điều trị sớm bệnh về cơ xương khớp cho thú cưng.</p>',
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => 15042000,
            'created_by' => 15042000,
        ]);
        DB::table('specialties')->insert([
            'id' => 24021016315828,
            'name' => 'Khoa Răng Hàm Mặt',
            'logo' => null,
            'description' => '<p><strong>Khoa Răng Hàm Mặt </strong>Không chỉ khám, điều trị ngoại trú, nội trú các bệnh lý về răng miệng, hàm mặt cho các thú cưng mà còn thực hiện tốt các dịch vụ chuyên khoa yêu cầu kỹ thuật cao.</p>',
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => 15042000,
            'created_by' => 15042000,
        ]);
        DB::table('specialties')->insert([
            'id' => 24021016322362,
            'name' => 'Spa',
            'logo' => null,
            'description' => '<p><strong>Spa </strong>Dịch vụ chăm sóc sức khỏe da lông thú cưng bao gồm: Vệ sinh cơ bản, cắt móng, vệ sinh tai, vắt tuyến hôi, tắm, dưỡng lông,... Đem đến cho thú cưng những giây phút tận hưởng thư thái nhất.</p>',
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => 15042000,
            'created_by' => 15042000,
        ]);
        DB::table('specialties')->insert([
            'id' => 24021016324010,
            'name' => 'Khách sạn, lưu trú',
            'logo' => null,
            'description' => '<p><strong>Khách sạn, lưu trú </strong>Cung cấp hệ thống lưu trú, trông giữ thú cưng chất lượng đạt chuẩn cho thú cưng mỗi khi gia chủ có dịp đi xa, lễ tết, Không gian riêng biệt cho các Boss có kỳ nghỉ dưỡng tuyệt với</p>',
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => 15042000,
            'created_by' => 15042000,
        ]);
        // Users
        DB::table('users')->insert([
            'id' => 15042000,
            'name' => 'Bùi Huy Anh',
            'email' => 'bujhuyanh150400@gmail.com',
            'password' => '$2y$12$I4FseFYK2HRptild0.CPNOabBBHHGu.vMD7ro3OPFpfzIusE1eTku', // su30mk2v
            'birth' => '2000-04-15 00:00:00',
            'address' => 'VN',
            'gender' => 1,
            'user_status' => 15,
            'phone' => '0917095494',
            'permission' => 16,
            'clinic_id' => 24021008224354,
            'specialties_id' => 24021016322362,
            'description' => '<p>Bác sĩ Huy Anh học ngành bác sĩ thú y tại trường Đại học Đại Y &nbsp;Tp.Hà Nội khóa 2012-2018. Sau đó, anh trở thành bác sĩ thực hành thú y thú nhỏ tại Bệnh viện từ 2021 đến nay.</p>',
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => 15042000,
            'created_by' => 15042000,
            'remember_token' => Str::random(10),
        ]);
        DB::table('users')->insert([
            'id' => intval(date('ymdHis') . rand(10, 99)),
            'name' => 'Ngạc Bảo Uyên',
            'email' => 'uyenpi1612@gmail.com',
            'password' => '$2y$12$I4FseFYK2HRptild0.CPNOabBBHHGu.vMD7ro3OPFpfzIusE1eTku', // su30mk2v
            'birth' => '2000-04-15 00:00:00',
            'address' => 'VN',
            'gender' => 1,
            'user_status' => 15,
            'phone' => '0345871628',
            'permission' => 16,
            'clinic_id' => 24021008224354,
            'specialties_id' => 24021016322362,
            'description' => '<p>Bác sĩ Bảo Uyên, vợ bác sĩ Huy Anh, học ngành bác sĩ thú y tại trường Đại học Đại Y &nbsp;Tp.Hà Nội khóa 2012-2018. Sau đó, anh trở thành bác sĩ thực hành thú y thú nhỏ tại Bệnh viện từ 2021 đến nay.</p>',
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => 15042000,
            'created_by' => 15042000,
            'remember_token' => Str::random(10),
        ]);
    }
}
