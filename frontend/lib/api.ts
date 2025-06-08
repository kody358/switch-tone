// frontend/lib/api.ts
const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api/v1';

class ApiClient {
  private baseURL: string;

  constructor(baseURL: string) {
    this.baseURL = baseURL;
  }

  private async request<T>(endpoint: string, options: RequestInit = {}): Promise<T> {
    const url = `${this.baseURL}${endpoint}`;
    
    const response = await fetch(url, {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...options.headers,
      },
      ...options,
    });

    if (!response.ok) {
      throw new Error(`API Error: ${response.status} ${response.statusText}`);
    }

    return response.json();
  }

  // キーボードスイッチ一覧を取得
  async getSwitches(params?: {
    search?: string;
    type?: string[];
    brand?: string[];
    price?: string[];
    sort?: string;
    order?: 'asc' | 'desc';
  }) {
    const searchParams = new URLSearchParams();
    
    if (params?.search) searchParams.append('search', params.search);
    if (params?.type?.length) searchParams.append('type', params.type.join(','));
    if (params?.brand?.length) searchParams.append('brand', params.brand.join(','));
    if (params?.price?.length) searchParams.append('price', params.price.join(','));
    if (params?.sort) searchParams.append('sort', params.sort);
    if (params?.order) searchParams.append('order', params.order);

    const query = searchParams.toString();
    const endpoint = `/switches${query ? `?${query}` : ''}`;
    
    return this.request<{ data: any[], message: string }>(endpoint);
  }

  // 特定のキーボードスイッチを取得
  async getSwitch(id: number) {
    return this.request<{ data: any, message: string }>(`/switches/${id}`);
  }

  // ブランド一覧を取得
  async getBrands() {
    return this.request<{ data: any[], message: string }>('/brands');
  }

  // 特定のブランドを取得
  async getBrand(slugOrId: string | number) {
    return this.request<{ data: any, message: string }>(`/brands/${slugOrId}`);
  }

  // ブランドのキーボードスイッチを取得
  async getBrandSwitches(slugOrId: string | number) {
    return this.request<{ data: any[], message: string }>(`/brands/${slugOrId}/switches`);
  }
}

export const apiClient = new ApiClient(API_BASE_URL);