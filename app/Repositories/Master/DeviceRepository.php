<?php

namespace App\Repositories\Master;

use App\Models\Master\Device;
use App\Traits\MainTrait;
use Illuminate\Support\Facades\DB;

class DeviceRepository
{
    use MainTrait;

    public function data($request)
    {
        return [
            'device_name'    => $request->device_name,
            'online_status'  => $request->online_status,
            'node_eui'       => $request->node_eui,
        ];
    }

    public function query($request)
    {
        $query = Device::query();

        if ($request->type == 'dropdown') {
            $query->select(
                $request->column
            )
                ->distinct();
        }
        return $query;
    }

    public function whereData($request): array
    {
        $query = $this->query($request);

        $search = $request->search;
        try {
            if (isset($search)) {
                $query = $query
                    ->where('device_name', 'like', '%' . $search . '%')
                    ->orWhere('online_status', 'like', '%' . $search . '%')
                    ->orWhere('node_eui', 'like', '%' . $search . '%');
            }
        } catch (\Exception $e) {
            return $this->responseArray(500,  'Failed to process data. Error: ' . $e->getMessage(), null);
        }
        return $this->responseArray(200, 'Success to Get data device.', $query);
    }

    public function countedFilter($request)
    {
        list($code, $data) = $this->whereData($request);
        return $data['data']->select('device_uuid')->get();
    }

    /** Fungsi untuk menampilkan seluruh data dari model atau database berdasarkan request yang telah diberikan oleh service*/
    public function showData($request)
    {

        try {
            list($code, $data)      = $this->whereData($request);
            if ($request->type == 'dropdown') {
                $response = $data['data']->limit(10)->get();
                if (count($response) <= 0) {
                    return $this->responseArray(200, 'Data not available.', []);
                }
            } else {

                if ($request['length'] != -1) {
                    $query = $data['data']->offset($request['start'] ?? 0)->limit($request['length'] ?? 10);
                }
                $query = $query->get();

                if (count($query) <= 0) {
                    return $this->responseArray(200, 'Data not available.', []);
                }

                $response = array(
                    "data"            => $query ?? [],
                    "draw"            => $request['draw'],
                    "recordsTotal"    => $query->count(),
                    "recordsFiltered" => count($this->countedFilter($request)) ?? 0,
                );
            }
        } catch (\Exception $e) {
            return $this->responseArray(500,  'Failed to process data. Error: ' . $e, null);
        }
        return $this->responseArray(200, 'Success to Get data device.', $response);
    }

    /** Fungsi untuk menampilkan data dari model atau database berdasarkan request yang telah diberikan oleh service*/
    public function showDataId($id): array
    {
        try {
            $device = Device::where('device_uuid', $id)->first();

            if (!$device) {
                return $this->responseArray(200, 'Data not available.', []);
            }
        } catch (\Exception $e) {
            return $this->responseArray(500,  'Failed to process data. Error: ' . $e->getMessage(), null);
        }
        return $this->responseArray(200, 'Success to Get data device.', $device);
    }

    /** Fungsi untuk menambahkan data dari model atau database berdasarkan request yang telah diberikan oleh service*/
    public function insertData($request): array
    {
        DB::beginTransaction();
        try {
            Device::create($this->data($request));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseArray(500,  'Failed to process data. Error: ' . $e->getMessage(), null);
        }
        DB::commit();
        return $this->responseArray(200, 'Success to Create data device.', true);
    }

    /** Fungsi untuk mengubah data dari model atau database berdasarkan id dan request yang telah diberikan oleh service */
    final public function updateData($request, $id)
    {
        DB::beginTransaction();
        try {
            $device = Device::where('device_uuid', $id)->first();

            if (!$device) {
                return $this->responseArray(200, 'Data not available.', []);
            }

            $device->update(
                array_merge($this->data($request), [
                    'updated_at'    => now() ?? null,
                    'updated_by'    => auth()->user()->id ?? null
                ])
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseArray(500,  'Failed to process data. Error: ' . $e->getMessage(), null);
        }
        DB::commit();
        return $this->responseArray(200, 'Success to Update data device.', true);
    }

    /** Fungsi untuk menghapusdata dari model atau databse berdasarkan id yang telah diberikan dari request */
    final public function deleteData($id)
    {
        DB::beginTransaction();

        $device = Device::where('device_uuid', $id)->first();

        try {
            if (!$device) {
                return $this->responseArray(200, 'Data not available.', []);
            }
            $device->delete();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseArray(500,  'Failed to process data. Error: ' . $e->getMessage(), null);
        }
        DB::commit();
        return $this->responseArray(200, 'Success to Delete data device.', true);
    }
}
